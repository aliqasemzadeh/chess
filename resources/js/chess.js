window.PlayChess = ({ initialFen, gameId, authUserId, whiteUserId, blackUserId, currentTurn }) => {
    return {
            fen: initialFen,
            board: null,
            game: null,
            error: '',
            currentTurn: currentTurn,
            colorForUser(userId) {
                return userId === whiteUserId ? 'white' : (userId === blackUserId ? 'black' : null);
            },
            isUsersTurn() {
                const turn = this.game.turn(); // 'w' or 'b'
                const userColor = this.colorForUser(authUserId);
                const isTurn = (turn === 'w' && userColor === 'white') || (turn === 'b' && userColor === 'black');
                console.log('Turn check:', { turn, userColor, isTurn });
                return isTurn;
            },
            init() {
                console.log('Initializing chess game with:', {
                    initialFen,
                    gameId,
                    authUserId,
                    whiteUserId,
                    blackUserId,
                    currentTurn
                });

                // Wait for assets to load
                if (!window.Chess || !window.CmChessboard) {
                    console.error('Chess assets not loaded');
                    this.error = 'Chess assets not loaded';
                    return;
                }

                // chess.js provided via window.Chess from app.js
                this.game = new window.Chess(this.fen);

                // cm-chessboard provided via window.CmChessboard from app.js
                const { Chessboard, COLOR, INPUT_EVENT_TYPE } = window.CmChessboard;

                const el = document.getElementById('board');
                if (!el) {
                    console.error('Board element not found');
                    return;
                }

                // Get piece sprite URL
                const pieceSpriteUrl = window.CmChessboardPieces?.stauntyUrl;
                console.log('Piece sprite URL:', pieceSpriteUrl);

                try {
                    this.board = new Chessboard(el, {
                        position: this.fen,
                        style: {
                            cssClass: 'cm-default',
                            showCoordinates: true,
                            pieces: pieceSpriteUrl ? { file: pieceSpriteUrl } : undefined
                        }
                    });
                    console.log('Chessboard initialized successfully');
                } catch (error) {
                    console.error('Failed to initialize chessboard:', error);
                    this.error = 'Failed to initialize chessboard: ' + error.message;
                    return;
                }

                // Enable move input and validate with chess.js
                const myColor = this.colorForUser(authUserId) === 'white' ? COLOR.white : COLOR.black;
                console.log('User color:', myColor);

                this.board.enableMoveInput((event) => {
                    this.error = '';
                    console.log('Move input event:', event.type);

                    if (event.type === INPUT_EVENT_TYPE.moveInputStarted) {
                        if (this.game.isGameOver() || !this.isUsersTurn()) {
                            this.error = 'نوبت شما نیست';
                            console.log('Move blocked:', { gameOver: this.game.isGameOver(), isUsersTurn: this.isUsersTurn() });
                            return false;
                        }
                        return true;
                    }
                    if (event.type === INPUT_EVENT_TYPE.validateMoveInput) {
                        const from = event.squareFrom;
                        const to = event.squareTo;
                        const fenBefore = this.fen;

                        console.log('Validating move:', { from, to, fenBefore });

                        // Pre-validate using chess.js generated legal moves to avoid exceptions
                        const legal = this.game.moves({ square: from, verbose: true }) || [];
                        const candidate = legal.find(m => m.to === to);
                        if (!candidate) {
                            this.error = 'حرکت نامعتبر است';
                            console.log('Invalid move - not in legal moves');
                            return false; // snap back
                        }

                        let move;
                        try {
                            // Use the candidate so chess.js is guaranteed to accept it
                            move = this.game.move({ from, to, promotion: candidate.promotion || 'q' });
                        } catch (e) {
                            console.error('Invalid move attempt caught:', e);
                            this.error = 'حرکت نامعتبر است';
                            return false; // snap back
                        }
                        if (!move) {
                            this.error = 'حرکت نامعتبر است';
                            return false; // snap back
                        }

                        console.log('Move executed:', move);

                        this.fen = this.game.fen();
                        // Reflect on board
                        this.board.setPosition(this.fen, true);

                        // Update move list (UI only)
                        const li = document.createElement('li');
                        li.textContent = move.san;
                        document.getElementById('moveList').appendChild(li);

                        // Persist via Livewire using the new method
                        const payload = {
                            from,
                            to,
                            san: move.san,
                            fen_before: fenBefore,
                            fen_after: this.fen,
                            meta: { check: this.game.isCheck(), checkmate: this.game.isCheckmate(), draw: this.game.isDraw() }
                        };

                        console.log('Sending payload to Livewire:', payload);

                        // Use Livewire method call instead of event
                        this.$wire.handleMove(payload);
                        return true;
                    }
                    if (event.type === INPUT_EVENT_TYPE.moveInputCanceled) {
                        return true;
                    }
                }, myColor);

                // Subscribe to broadcast updates for this game
                if (window.Echo) {
                    window.Echo.private('game.' + gameId)
                        .listen('.game.move', (e) => {
                            console.log('Received broadcast move:', e);
                            // Another player's move: update local board/FEN
                            if (e && e.fen) {
                                this.fen = e.fen;
                                this.game.load(e.fen);
                                this.board.setPosition(e.fen, true);
                                // Update turn
                                this.currentTurn = this.game.turn() === 'w' ? 'white' : 'black';
                                // Append move if present
                                if (e.move && e.move.san) {
                                    const li = document.createElement('li');
                                    li.textContent = e.move.san;
                                    document.getElementById('moveList').appendChild(li);
                                }
                            }
                        });
                }

                // Listen to Livewire browser event to sync local state when I move
                window.addEventListener('move-saved', (event) => {
                    console.log('Received move-saved event:', event);
                    if (event && event.detail && event.detail.fen) {
                        this.fen = event.detail.fen;
                        this.game.load(this.fen);
                        this.board.setPosition(this.fen, true);
                        // Update turn
                        this.currentTurn = this.game.turn() === 'w' ? 'white' : 'black';
                    }
                });
            },
        }
}


// Alias for Alpine usage in Blade: x-data="chessPlay({...})"
if (typeof window !== 'undefined' && window.PlayChess) {
    window.chessPlay = window.PlayChess;
}
