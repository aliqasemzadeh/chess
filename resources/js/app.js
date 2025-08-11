import './bootstrap';
import 'flowbite';
import 'cm-chessboard/assets/styles/cm-chessboard.css';

// Import chess.js and cm-chessboard and expose to window for Alpine/Blade inline scripts
import { Chess } from 'chess.js';
import { Chessboard, COLOR, INPUT_EVENT_TYPE } from 'cm-chessboard';

window.Chess = Chess;
window.CmChessboard = { Chessboard, COLOR, INPUT_EVENT_TYPE };

