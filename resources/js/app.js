import './bootstrap';
import 'flowbite';
import 'cm-chessboard/assets/chessboard.css';

// Import chess.js and cm-chessboard and expose to window for Alpine/Blade inline scripts
import { Chess } from 'chess.js';
import { Chessboard, COLOR, INPUT_EVENT_TYPE } from 'cm-chessboard';

// Import a local piece sprite via Vite to avoid CORS and expose its URL
import stauntyPiecesUrl from 'cm-chessboard/assets/pieces/staunty.svg';

window.Chess = Chess;
window.CmChessboard = { Chessboard, COLOR, INPUT_EVENT_TYPE };
window.CmChessboardPieces = { stauntyUrl: stauntyPiecesUrl };

