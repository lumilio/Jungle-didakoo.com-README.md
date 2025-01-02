<template>
    <div style="width: 100%">
        <svg
            style="background-color: #feb442"
            ref="svg"
            :viewBox="`0 0 ${viewBox.x} ${viewBox.y}`"
        >
            <g>
                <River
                    :x="boardSettings.padding + boardSettings.square.width"
                    :y="boardSettings.square.height * 3"
                    :width="boardSettings.square.width * 2"
                    :height="boardSettings.square.height * 3"
                />
            </g>
            <g>
                <River
                    :x="boardSettings.padding + boardSettings.square.width * 4"
                    :y="boardSettings.square.height * 3"
                    :width="boardSettings.square.width * 2"
                    :height="boardSettings.square.height * 3"
                />
            </g>
            <g class="squares">
                <g
                    v-for="(squareRow, squareRowIndex) in squares"
                    :key="squareRowIndex"
                    class="square-row"
                >
                    <g
                        v-for="(square, squareColIndex) in squareRow"
                        :key="square.code"
                        :ref="square.code"
                        :class="{
                            square: true,
                            [`square-${square.code}`]: true,
                        }"
                        @click="
                            squareClick(squareRowIndex, squareColIndex)
                        "
                    >
                        <rect
                            :x="square.x"
                            :y="square.y"
                            :width="square.width"
                            :height="square.height"
                            :fill="
                                square.isPossibleMove

                                    ? possibleMoveColor(square.code,square.color)
                                    : playColors[square.color]
                            "
                        ></rect>
                        <rect
                            v-show="square.isPossibleMove"
                            :x="square.x + square.width / 2 - 5"
                            :y="square.y + square.height / 2 - 5"
                            width="10"
                            height="10"
                            rx="50"
                            fill="#ffffff"
                        />
                    </g>
                </g>
            </g>
            <g @click="squareClick(0,3)">
                <Den1
                    :x="boardSettings.padding + boardSettings.square.width * 3"
                    :y="0"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                    :color="checkAddress ? this.boardColors?.black : this.boardColors?.white"
                    v-show="game?.opponent?.wallet_address"
                />
            </g>
            <g @click="squareClick(8,3)">
                <Den2
                    :x="boardSettings.padding + boardSettings.square.width * 3"
                    :y="boardSettings.square.height * 8"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                    :color="checkAddress ? this.boardColors?.white : this.boardColors?.black"
                />
            </g>
            <g @click="squareClick(0,2)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 2"
                    :y="0"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g @click="squareClick(0,4)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 4"
                    :y="0"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g @click="squareClick(1,3)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 3"
                    :y="boardSettings.square.height"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g @click="squareClick(8,2)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 2"
                    :y="boardSettings.square.height * 8"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g @click="squareClick(8,4)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 4"
                    :y="boardSettings.square.height * 8"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g @click="squareClick(7,3)">
                <Trap
                    :x="boardSettings.padding + boardSettings.square.width * 3"
                    :y="boardSettings.square.height * 7"
                    :width="boardSettings.square.width"
                    :height="boardSettings.square.height"
                />
            </g>
            <g class="squares">
                <g
                    v-for="(squareRow, squareRowIndex) in squares"
                    :key="squareRowIndex"
                    class="square-row"
                >
                    <g
                        v-for="(square, squareColIndex) in squareRow"
                        :key="square.code"
                        :ref="square.code"
                        :class="{
                            square: true,
                            [`square-${square.code}`]: true,
                        }"
                        @click="
                            squareClick(squareRowIndex, squareColIndex)
                        "
                    >
                        <g v-if="square.content.piece" v-show="game?.opponent?.wallet_address ? square.content.y >= 0 : square.content.y >= 170">
                            <Piece
                                :avatar-color="boardColors[square.content.color]"
                                :key="square.code"
                                :name="square.content.piece"
                                :x="square.content.x"
                                :y="square.content.y + 10"
                                :transformX="gamePieceMoveCoords.toX"
                                :transformY="gamePieceMoveCoords.toY"
                                :isMoves="
                                    square.content.piece ===
                                        gamePieceMoveCoords.piece &&
                                    square.content.color ===
                                        gamePieceMoveCoords.color
                                "
                                :width="square.content.width"
                                :height="square.content.height"
                                :color="square.content.color"
                            />
                        </g>
                    </g>
                </g>
            </g>
        </svg>
    </div>
</template>

<script>
import { ref } from "vue";
import store from "../../store";
import helper from "./GameHelper";
import Piece from "./Elements/Piece";
import River from "./Elements/River";
import Den1 from "./Elements/Den1";
import Den2 from "./Elements/Den2";
import Trap from "./Elements/Trap";
import {trapGuards} from "./constants";
import axios from "axios";

const animals = helper.getAnimalPowers();
const waterCodes = helper.getWaterCodes()
const trapCodes = helper.getTrapCodes();
const houseCodes = helper.getHouseCodes();
const protectHouseCodes = helper.getProtectHouseCodes();
const backgroundColors = helper.getBoardColors();
const allowedColors = helper.getAllowedColors();
export default {
    name: "MultiPlay",
    components: {
        Piece,
        River,
        Den1,
        Den2,
        Trap,
    },
    emits: ['gameover','connected'],
    props: {
        boardSettings: {
            required: false,
            type: Object,
            default: () => ({
                padding: 0,
                showNotation: true,
                baseColor: "#000000",
                square: {
                    width: 80,
                    height: 80,
                },
            }),
        },
        id: String,
        game: Object,
        color: {
            type: Object,
            default: () => ({
                light: "#feb442",
                dark: "#55555500",
                possibleMoveWater: "#00e4ffa3",
                possibleStroke: "#b59f67",
            }),
        },
    },
    data() {
        return {
            openBoard: false,
            gameStarted: false,
            possibleMove:  "" ,
            GreenBoardColor:"#9be8b4",
            OrangeBoardColor:"#FFE194",
            viewBox: { x: 560, y: 720 },
            boardColors: {
                black: 0,
                white: 0,
                board: 0
            },
            playColors: {
                light: '#feb442',
                dark: this.color.dark,
                possibleMove: this.color.possibleMove,
                possibleMoveWater: this.color.possibleMoveWater,
                possibleStroke: this.color.possibleStroke,
            },
            counterStrike: 0,
            mouseLocation: ref({ x: 0, y: 0 }),
            squares: ref([]),
            turnNumber: ref(1),
            possibleMoves: ref([]),
            gamePieceMoveCoords: {
                piece: null,
                toX: 0,
                toY: 0,
                color: "",
            },
            state: null,
            svg: ref(null),
            isHoldingChessPiece: ref(false),
            holding: ref({ row: null, col: null }),
        };

    },
    async mounted()
    {
        this.setInitialConfig();

        if (this.game?.opponent?.wallet_address === store.state.address && this.game.state.turn === "black"){
            this.openBoard = true
        }else if(this.game?.creator?.wallet_address === store.state.address && this.game.state.turn === "white"){
            this.openBoard = true
        }
        Pusher.logToConsole = false;
        const pusher = new Pusher('aaf9c43e10a6d5e65efe', {
            cluster: 'eu'
        });
        const channel = pusher.subscribe('quit.' + store.state.address)
        channel.bind('App\\Events\\QuitGame',  async (data) => {
            localStorage.removeItem('canStart')
            this.$emit('gameover', 'white')
        });
        if (store.state.address && this.game.status === "started"){
            // TODO subscribe
            const channel = pusher.subscribe('game.' + this.game.id + '.' + store.state.address );

            channel.bind('App\\Events\\DoStep', (data) => {
                if (data.player === store.state.address){
                    const keys = {
                        'A': 0,
                        'B': 1,
                        'C': 2,
                        'D': 3,
                        'E': 4,
                        'F': 5,
                        'G': 6,
                    }
                    let fromSquare = {};
                    let toSquare = {};
                    Object.keys(data.state.state).forEach((item) => {
                        if (!this.state[item]){
                            if (store.state.address === this.game?.opponent?.wallet_address){
                                toSquare = this.squares[item[1] - 1][keys[item[0]]];
                            }else{
                                toSquare = this.squares[9 - item[1]][keys[item[0]]]
                            }
                        }
                    })
                    Object.keys(this.state).forEach((item) => {
                        if (!data.state.state[item]){
                            if (store.state.address === this.game?.opponent?.wallet_address){
                                fromSquare = this.squares[item[1] - 1][keys[item[0]]];
                            }else{
                                fromSquare = this.squares[9 - item[1]][keys[item[0]]]
                            }
                        }
                    })
                    if(!toSquare.code){
                        if (store.state.address === this.game?.opponent?.wallet_address){
                            toSquare = this.squares[data.lastMove.to[1] - 1][keys[data.lastMove.to[0]]]
                        }else{
                            toSquare = this.squares[data.lastMove.to[1] - 1][keys[data.lastMove.to[0]]];
                        }
                    }
                    this.makeMove(fromSquare, toSquare);
                    if(toSquare.code === 'D1' && (data.state.turn === "white" || data.state.turn === "black")){
                        this.$emit('gameover', "black")
                        localStorage.removeItem('canStart')
                        this.playAgain()
                    }
                    this.turn = data.state.turn
                    this.state = data.state.state
                    this.openBoard = true;
                }
            });
        }else if (store.state.address){
            const channel = pusher.subscribe('connect.' + store.state.address);
            channel.bind('App\\Events\\ConnectGame', (data) => {
                this.gameStarted = true;
                this.openBoard = true;
                this.$emit('connected')
            });
        }

    },
    watch: {
        gameStarted(data){
            if (data){
                this.openBoard = this.game.state.turn === "white";
                Pusher.logToConsole = false;
                const pusher = new Pusher('aaf9c43e10a6d5e65efe', {
                    cluster: 'eu'
                });
                const channel = pusher.subscribe('game.' + this.game.id + '.' + store.state.address);
                channel.bind('App\\Events\\DoStep', (data) => {
                    if (data.player === store.state.address){
                        if (data.player === store.state.address){
                            const keys = {
                                'A': 0,
                                'B': 1,
                                'C': 2,
                                'D': 3,
                                'E': 4,
                                'F': 5,
                                'G': 6,
                            }
                            let fromSquare = {};
                            let toSquare = {};
                            Object.keys(data.state.state).forEach((item) => {
                                if (!this.game.state.state[item]){
                                    toSquare = this.squares[keys[item[0]]][item[1] - 1];
                                }
                            })
                            Object.keys(this.game.state.state).forEach((item) => {
                                if (!data.state.state[item]){
                                    fromSquare = this.squares[keys[item[0]]][item[1] - 1];
                                }
                            })
                            this.makeMove(fromSquare, toSquare);
                            this.turn = this.game.state.turn
                            this.openBoard = false;
                        }
                    }
                });
            }
        }
    },
    computed: {
        turn: {
            get: function () {
                return store.state.turn;
            },
            set: function (val) {
                return store.commit("CHANGE_TURN", val);
            },
        },
        address() {
            return store.state.address
        },
        userData(){
            return store.state.userData
        },
        borderColor(){
            return this.game?.state?.colors?.border
        },
        checkAddress(){
            return this.game?.creator?.wallet_address === this.address
        }
    },
    methods: {
        setInitialConfig(){
            if(this.game && this.game.state){
                this.state = this.game.state
                const state = this.game.state;
                this.fillState(state.state)
                this.fillColors(state)
                this.turn = state.turn
            }
            this.initSquares();
        },
        isRiverBlocked(side) {
            let rowStart = 3,
                colStart;
            colStart = side === "left" ? 1 : 4;
            for (let i = rowStart; i < rowStart + 3; i++) {
                for (let j = colStart; j < colStart + 2; j++) {
                    if (this.squares[i][j].content.piece === "mouse") {
                        return true;
                    }
                }
            }
            return false;
        },
        possibleMoveColor(code) {
            return waterCodes.includes(code)
                ? this.color.possibleMoveWater
                : this.possibleMove
        },
        squareTypeInfo(code) {
            if (!code) return null;
            if (waterCodes.includes(code)) {
                return {
                    type: "water",
                    position: waterCodes.indexOf(code) < 6 ? "left" : "right",
                };
            }
            if (trapCodes.all.includes(code)) {

                let position
                if(this.turn === 'black'){
                    position =  trapCodes.all.indexOf(code) >= 3 ? "black" : "white";
                }else if(this.turn === 'white'){
                    position = trapCodes.all.indexOf(code) < 3 ? "black" : "white"
                }
                return {
                    type: "trap",
                    position: position
                };
            }
            if (houseCodes.all.includes(code)) {
                return {
                    type: "dom",
                    position: code === "D9" ? this.game?.creator?.wallet_address === this.address ? "black" : "white" : this.game?.opponent?.wallet_address === this.address ? "black" : "white",
                };
            }
            return {
                type: "land",
            };
        },
        outOfBoard(x, y) {
            return y < 0 || x < 0 || y > 8 || x > 6;
        },
        getLandingPosition(animalX, animalY, landingX, landingY) {
            if (animalX === landingX) {
                if (landingY > animalY) {
                    return {
                        x: landingX,
                        y: landingY + 3,
                    };
                } else {
                    return {
                        x: landingX,
                        y: landingY - 3,
                    };
                }
            } else {
                if (landingX > animalX) {
                    return {
                        x: landingX + 2,
                        y: landingY,
                    };
                } else {
                    return {
                        x: landingX - 2,
                        y: landingY,
                    };
                }
            }
        },
        canBeatAnimal(animal, attacker) {
            return (
                attacker.color !== animal.color &&
                ((attacker.power >= animal.power &&
                        !attacker.vulnerability?.includes(animal.name)) ||
                    attacker.specialPower?.canBeat?.includes(animal.name))
            );
        },
        getAnimalByCode(x, y) {
            let square = this.squares[y][x];
            if (square.content?.piece) {
                return {
                    animal: square.content.piece,
                    color: square.content.color,
                };
            }
            return null;
        },
        canJump(animal, direction) {
            return (
                animal.specialPower?.canJumpOverTheRiver &&
                animal.specialPower?.jumpDirections?.includes(direction)
            );
        },
        getSquareContent(code){
            if(this.state){
                return this.state
            }else{
                return helper.getInitialState();
            }
        },
        fillState(data){

            if(!data){
                this.state = helper.getInitialState()
            }
            else{
                this.state = data
            }
        },
        fillColors(data){
            if (data){
                let checkAddress = this.game?.creator?.wallet_address === this.address ?? true
                if(this.game?.creator?.color_id || this.game?.opponent?.color_id){
                    if(this.game?.creator?.color_id && this.game?.opponent?.color_id) {
                        this.boardColors = {
                            black: this.game?.opponent?.color_id,
                            board: 2,
                            white: this.game?.creator?.color_id
                        }
                        this.possibleMove = "#9be8b4"
                    }
                    if((this.game?.creator?.color_id === this.game?.opponent?.color_id) ||
                       (this.game?.creator?.color_id === 2 && this.game?.opponent?.color_id === 4) ||
                       (this.game?.creator?.color_id === 4 && this.game?.opponent?.color_id === 2)
                    ){
                        this.boardColors = {
                            black : 5,
                            board : 1,
                            white : 6
                        }
                        this.possibleMove = "#FFE194"
                    }else{
                        if(!this.game?.opponent?.color_id && this.game?.creator?.color_id){
                            this.boardColors = {
                                black : data.colors?.black,
                                board : 2,
                                white : this.game?.creator?.color_id
                            }
                            if(this.boardColors.black === this.game?.creator?.color_id){
                                if(this.game?.creator?.color_id === 4){
                                    this.boardColors.black = this.game?.creator?.color_id - 1
                                }else{
                                    this.boardColors.black = this.game?.creator?.color_id + 1
                                }
                            }
                            if((this.game?.creator?.color_id === 2 && this.boardColors.black === 4) || (this.game?.creator?.color_id === 4 && this.boardColors.black === 2)){
                                this.boardColors.black = this.game?.creator?.color_id - 1
                            }
                            this.possibleMove = "#9be8b4"
                        }
                        if (this.game?.opponent?.color_id && !this.game?.creator?.color_id){
                            this.boardColors = {
                                black : this.game?.opponent?.color_id,
                                board : 2,
                                white : (data.colors?.white === 5 || data.colors?.white ===  6) ? data.colors?.white - 2 : data.colors?.white
                            }
                            if(this.game?.opponent?.color_id === this.boardColors.white){
                                if(this.game?.opponent?.color_id === 4){
                                    this.boardColors.white = this.game?.opponent?.color_id - 1
                                }else{
                                    this.boardColors.white = this.game?.opponent?.color_id + 1
                                }
                            }
                            if((this.game?.opponent?.color_id === 2 && this.boardColors.white === 4) || (this.game?.opponent?.color_id === 4 && this.boardColors.white === 2)){
                                this.boardColors.white = this.game?.opponent?.color_id - 1
                            }

                            this.possibleMove = "#9be8b4"
                        }
                    }
                }else{
                    this.boardColors = data.colors;
                    if((data.colors?.white === 2 && data.colors?.black === 4) || (data.colors?.white === 4 && data.colors?.black === 2)){
                        this.boardColors.black = data.colors?.black - 1
                    }
                    if (data.colors.board === 2){
                        this.possibleMove = "#9be8b4"
                    }else {
                        this.possibleMove = "#FFE194"
                    }
                }
                this.playColors.light = backgroundColors[this.boardColors?.board]
            }
        },
        initSquares() {
            this.squares = [];
            let squareContent =  this.getSquareContent()
            if(this.game?.opponent?.wallet_address === store.state.address){
                const newSquareContent = {};
                for (const [key, value] of Object.entries(squareContent)) {
                    newSquareContent[`${key[0]}${10 - key[1]}`] = value;
                }
                squareContent = newSquareContent;
            }
            for (let i = 0; i < 9; i++) {
                this.squares.push([]);
                for (let j = 0; j < 7; j++) {
                    let squarePosition = helper.getSquarePosition(
                        i,
                        j,
                        this.boardSettings
                    );
                    let code = helper.getSquareCode(i, j);
                    let content = squareContent[code] || {}
                    let pieceSize = {
                        width: this.boardSettings.square.width,
                        height: this.boardSettings.square.height,
                    };
                    this.squares[i].push({
                        isPossibleMove: false,
                        code,
                        i,
                        j,
                        row: i,
                        col: j,
                        visible: true,
                        areaColor: i < 3 ? "black" : i > 5 ? "white" : null,
                        color: helper.getSquareColor(i, j),
                        content: {
                            stepNumber: 1,
                            color: content.color,
                            piece: content.piece,
                            ...squarePosition,
                            ...pieceSize,
                        },
                        ...squarePosition,
                        ...this.boardSettings.square,
                    });
                }
            }
        },
        squareClick( rowIndex, colIndex) {
            if(this.game.status !== "started") return;
            let square = this.squares[rowIndex][colIndex];
            if (!this.releasePiece(square)) {
                if (square.content.piece && square.content.color === this.turn && this.openBoard) {
                    this.showPossibleMoves(rowIndex, colIndex);
                    this.holding.row = rowIndex;
                    this.holding.col = colIndex;
                    this.holdPiece( square);
                }
            }
        },
        makeMove(fromSquare, toSquare) {
            this.gamePieceMoveCoords = {
                piece: fromSquare.content?.piece,
                toX: toSquare.x - fromSquare.x,
                toY: toSquare.y - fromSquare.y,
                color: this.turn,
            };
            this.updateState({
                fromCode: fromSquare.code,
                toCode: toSquare.code,
                piece: fromSquare.content.piece,
                color: fromSquare.content.color,
            })
            toSquare.content.piece = fromSquare.content?.piece;
            toSquare.content.color = fromSquare.content?.color;
            toSquare.content.stepNumber++;
            toSquare.visible = true;
            fromSquare.content.piece = null;
            fromSquare.content.color = null;
        },
        updateState(data){
            const {fromCode, toCode, piece, color } = data
            if (this.address === this.game?.opponent?.wallet_address && this.turn === "black"){
                this.state[`${toCode[0]}${10 - toCode[1]}`] = {
                    color,
                    piece
                }
                if(this.state[`${fromCode[0]}${10 - fromCode[1]}`]){
                    delete this.state[`${fromCode[0]}${10 - fromCode[1]}`]
                }
            }else{
                this.state[toCode] = {
                    color,
                    piece
                }
                if(this.state[fromCode]){
                    delete this.state[fromCode]
                }
            }

            this.openBoard = false;
        },
        async saveState(fromSquareCode, toSquareCode){
            await axios.post('/api/set-state',{
                state: this.state,
                lastMove: {
                    from: fromSquareCode,
                    to: toSquareCode
                },
                turn: this.turn,
                id:this.id,
                colors: this.boardColors,
                address: this.address
            })
        },
        async alertWin(winner){
            try {
                await axios.post('/api/finish-game',{
                    player: this.address,
                    win: winner,
                    game_id: this.id
                })
                localStorage.removeItem('canStart')
                this.$emit('gameover',winner)
                this.playAgain()
            }catch (e) {
                console.log(e,'error message')
            }

        },
        releasePiece(toSquare) {
            if (!this.isHoldingChessPiece) return false;
            let fromSquare = this.squares[this.holding.row][this.holding.col];

            if (!toSquare.isPossibleMove) {
                this.isHoldingChessPiece = null;
                fromSquare.visible = true;
                this.clearPossibleMoves();
                return false;
            }
            this.makeMove(fromSquare, toSquare);
            this.isHoldingChessPiece = false;

            this.turnNumber++;

            this.clearPossibleMoves();
            let checkmate = this.isCheckmate(this.squares)
            this.saveState(fromSquare.code, toSquare.code)
            if(checkmate){
                setTimeout(() => {
                    this.alertWin(checkmate)
                },500)
            }else{
                this.turn = this.getOpponentColor(this.turn);
            }
            return true;
        },

        playAgain() {
            this.initSquares();
            this.turn = "white";
            this.turnNumber = 0;
            store.commit("RESET_MOVES_HISTORY");
        },
        isCheckmate(board) {
            if(board[0][3].content.piece || board[8][3].content.piece){
                return board[0][3].content.piece ? 'white': 'black'
            }
            const pieces = {
                white: false,
                black: false,
            }
            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 7; col++) {
                    const square = board[row][col] ;
                    if(square.content.piece){
                        pieces[square.content.color] = true
                    }
                }
            }
            if(!pieces.white || !pieces.black){
                return !pieces.black ? 'white' : 'black'
            }
            return false;
        },

        makeItPossible(square) {
            square.isPossibleMove = true;
            this.possibleMoves.push(square);
        },
        clearPossibleMoves() {
            for (let i = 0; i < this.possibleMoves.length; i++) {
                this.possibleMoves[i].isPossibleMove = false;
            }
            this.possibleMoves = ref([]);
        },

        /**
         * Hold a chess piece to a square
         */
        holdPiece( square) {
            if (
                !square.content.piece ||
                square.content.color !== this.turn ||
                this.possibleMoves.length === 0
            )
                return;
            this.isHoldingChessPiece = square;
            square.visible = false;
        },

        getPossibleMoves(squareRowIndex, squareColIndex, board = this.squares) {
            const square = board[squareRowIndex][squareColIndex];
            let moveTargets = helper.getKnightPossibleMoves(
                squareRowIndex,
                squareColIndex
            );
            const currentAnimalInfo = {
                ...animals[square.content.piece],
                color: square.content?.color,
            };
            const currentSquareColor = square.content?.color;
            const currentSquareType = this.squareTypeInfo(square.code);
            if (
                currentSquareType.type === "trap" &&
                currentSquareType.position !== currentSquareColor
            ) {
                currentAnimalInfo.power = 0;
            }
            const possibleMovesResult = [];
            const collectPossible = (row, col) => {
                possibleMovesResult.push({
                    fromRow: squareRowIndex,
                    fromCol: squareColIndex,
                    toRow: row,
                    toCol: col,
                });
            };
            moveTargets.forEach((target) => {
                let { rowIndex, colIndex } = target;
                if (this.outOfBoard(colIndex, rowIndex)) return;
                const targetSquare = board[rowIndex][colIndex];
                const targetSquareInfo = this.squareTypeInfo(targetSquare.code);
                const targetSquareAnimal = targetSquare.content.piece
                    ? {
                        ...animals[targetSquare.content.piece],
                        color: targetSquare.content.color,
                    }
                    : null;
                if (
                    !targetSquareInfo ||
                    (targetSquareAnimal &&
                        targetSquareAnimal.color === currentSquareColor)
                ) {
                    return;
                }
                switch (targetSquareInfo.type) {
                    case "water":
                        if (currentAnimalInfo.specialPower?.canSwim) {
                            collectPossible(rowIndex, colIndex);
                            return;
                        }
                        else if (
                            this.canJump(
                                currentAnimalInfo,
                                squareRowIndex === rowIndex
                                    ? "horizontal"
                                    : "vertical"
                            ) &&
                            !this.isRiverBlocked(
                                colIndex > 3 ? "right" : "left"
                            )
                        ) {
                            let jumpingTargetCoordinates =
                                this.getLandingPosition(
                                    squareColIndex,
                                    squareRowIndex,
                                    colIndex,
                                    rowIndex
                                );
                            let possibleTargetAnimal = this.getAnimalByCode(
                                jumpingTargetCoordinates.x,
                                jumpingTargetCoordinates.y
                            );
                            if (
                                !possibleTargetAnimal ||
                                this.canBeatAnimal(
                                    {
                                        ...animals[possibleTargetAnimal.animal],
                                        color: possibleTargetAnimal.color,
                                    },
                                    currentAnimalInfo
                                )
                            ) {
                                collectPossible(
                                    jumpingTargetCoordinates.y,
                                    jumpingTargetCoordinates.x
                                );
                                return;
                            }
                        }
                        break;
                    case "trap":
                        // if target is ours the move is possible
                        if (targetSquareInfo.position === currentSquareColor) {
                            collectPossible(rowIndex, colIndex);
                            return;
                        }
                        else if (
                            !targetSquareAnimal ||
                            this.canBeatAnimal(
                                targetSquareAnimal,
                                currentAnimalInfo
                            )
                        ) {
                            collectPossible(rowIndex, colIndex);
                            return;
                        }
                        break;
                    case "dom":
                        if (targetSquareInfo.position !== currentSquareColor) {
                            collectPossible(rowIndex, colIndex);
                            return;
                        }
                        break;
                    case "land":
                        if (!targetSquareAnimal) {
                            collectPossible(rowIndex, colIndex);
                            return;
                        } else {
                            if (
                                this.canBeatAnimal(
                                    targetSquareAnimal,
                                    currentAnimalInfo
                                )
                            ) {
                                collectPossible(rowIndex, colIndex);
                                return;
                            }
                        }
                }
            });
            return possibleMovesResult;
        },
        showPossibleMoves(squareRowIndex, squareColIndex) {
            let moves = this.getPossibleMoves(squareRowIndex, squareColIndex);
            moves.forEach((move) => {
                let square = this.squares[move.toRow][move.toCol];
                square.isPossibleMove = true;
                this.possibleMoves.push(square);
            });
        },
        cloneBoard(board) {
            const clonedBoard = [];
            for (let row = 0; row < 9; row++) {
                const newRow = [];
                for (let col = 0; col < 7; col++) {
                    const square = { ...board[row][col] };
                    newRow.push(square);
                }
                clonedBoard.push(newRow);
            }
            return clonedBoard;
        },
        makeVirtualMove(board, move, zzz = false) {
            let boardClone = this.cloneBoard(board);
            const { fromRow, fromCol, toRow, toCol } = move;
            const fromSquare = boardClone[fromRow][fromCol];
            const toSquare = boardClone[toRow][toCol];
            toSquare.content = fromSquare.content;
            fromSquare.content = {
                piece: null,
                color: null
            };
            return boardClone;
        },
        trapIsSafe(board, code) {
            const color = trapCodes.black.includes(code) ? "black" : "white";
            let secured = false;
            trapGuards[code].forEach((val) => {
                let coord = helper.getIndexesByCode(val);
                let square = board[coord.rowIndex][coord.colIndex];
                if (square.content.piece && square.content.color === color) {
                    secured = true;
                }
            });
            return secured;
        },
        checkPossibleWin(board, moves, color) {
            const opponentsColor = this.getOpponentColor(color);
            for (let i = 0; i < moves.length; i++) {
                const move = moves[i];
                const code = helper.getSquareCode(move.toRow, move.toCol);
                if (
                    (trapCodes[opponentsColor].includes(code) &&
                        !this.trapIsSafe(board, code)) ||
                    houseCodes[opponentsColor] === code
                ) {
                    return move;
                }
            }
            return null;
        },
        getDistanceFromHouse(square,color){
            const row = color === 'black' ? 0 : 8, col = 3
            return Math.abs(row - square.row) + Math.abs(col - square.col);
        },
        getBattleStrategy(board,color){
            let defence = false;
            let attack = false;
            let defenceDistance = 20;
            let attackDistance = 20;
            let urgency = false;
            for(let i = 0; i < 9 ; i++){
                for(let j = 0; j < 7 ; j++){
                    const square = board[i][j];
                    if(square.areaColor && square.content.piece && square.content.color !== square.areaColor){
                        if(square.areaColor === color){
                            if(protectHouseCodes[square.areaColor].includes(square.code)){
                                urgency = true
                                defenceDistance = Math.min(defenceDistance,this.getDistanceFromHouse(square,square.areaColor))
                            }
                            defence = true;
                        }else{
                            if(protectHouseCodes[square.areaColor].includes(square.code)){
                                urgency = true
                                attackDistance = Math.min(attackDistance,this.getDistanceFromHouse(square,square.areaColor))
                            }
                            attack = true;
                        }
                    }
                }
            }
            if(defenceDistance !== attackDistance) {
                if (defenceDistance < attackDistance) {
                    attack = false
                } else {
                    defence = false
                }
            }
            const scenario = attack && defence ? 'normal' : (attack || defence) ? attack ? 'attack' : 'defence' : 'attack';
            return {
                scenario,
                urgency
            }
        },
        calculateBestMove(
            board,
            color,
            depth = 3,
            alpha = -Infinity,
            beta = Infinity
        ) {
            let validMoves = this.getBoardPossibleMoves(board, color);
            if (color === "black") {
                validMoves = validMoves.sort((a, b) => b.fromRow - a.fromRow);
            }
            let bestScore = -Infinity;
            let bestMove = null;
            let bestMoves = [];
            let winMove = this.checkPossibleWin(board, validMoves, color);
            if(winMove){
                return winMove
            }else{
                for (let i = 0; i < validMoves.length; i++) {
                    const move = validMoves[i];
                    const newBoard = this.makeVirtualMove([...board], move);
                    const score = this.recursiveMove(
                        newBoard,
                        depth - 1,
                        alpha,
                        beta,
                        false,
                        color
                    );
                    if (score >= bestScore) {
                        if (score > bestScore) {
                            bestScore = score;
                            bestMove = move;
                            bestMoves = [move];
                        } else {
                            bestMoves.push(move);
                        }
                    }
                    alpha = Math.max(alpha, score);
                }
                if (bestMoves.length) {
                    return bestMoves[Math.floor(Math.random() * bestMoves.length)];
                }
                return validMoves.length ? validMoves[0] : {};
            }

        },
        recursiveMove(
            board,
            depth,
            alpha,
            beta,
            isMaximizingPlayer,
            playerColor
        ) {
            if (depth === 0) {
                return this.evaluateBoard(
                    board,
                    playerColor,
                    isMaximizingPlayer
                );
            }
            const currentPlayerColor = isMaximizingPlayer
                ? playerColor
                : this.getOpponentColor(playerColor);
            let moves = this.getBoardPossibleMoves(board, currentPlayerColor);
            if(currentPlayerColor === "black"){
                moves = moves.sort((a, b) => b.fromRow - a.fromRow);
            }
            if (isMaximizingPlayer) {
                let maxEval = -Infinity;
                for (const move of moves) {
                    const newBoard = this.makeVirtualMove(board, move);
                    const evaluate = this.recursiveMove(
                        newBoard,
                        depth - 1,
                        alpha,
                        beta,
                        false,
                        playerColor
                    );
                    maxEval = Math.max(maxEval, evaluate);
                    alpha = Math.max(alpha, evaluate);
                    if (alpha >= beta) {
                        break;
                    }
                }
                return maxEval;
            } else {
                let minEval = Infinity;
                for (const move of moves) {
                    const newBoard = this.makeVirtualMove(board, move);
                    const evaluate = this.recursiveMove(
                        newBoard,
                        depth - 1,
                        alpha,
                        beta,
                        true,
                        playerColor
                    );
                    minEval = Math.min(minEval, evaluate);
                    beta = Math.min(beta, evaluate);
                    if (alpha >= beta) {
                        break;
                    }
                }
                return minEval;
            }
        },
        getBoardFactors(board,color){
            const factors = {
                controlOfSquare: 20,
                controlOfOwnTrap: 2,
                guardOwnTrap: 5,


                controlOfOpponentsSquare: 5,
                controlOfOpponentsTrap: 5,
                guardOpponentsTrap: 0,


                winFactor: 1000000,
                attack: 5
            }
            const strategy = this.getBattleStrategy(board,color)

            if(strategy.scenario === 'attack'){
                factors.guardOpponentsTrap = 10
                factors.controlOfOpponentsTrap = 20
                if(strategy.urgency){
                    factors.guardOpponentsTrap = 100
                    factors.controlOfOpponentsTrap = 200
                }

            }else if(strategy.scenario === 'defence'){
                factors.guardOwnTrap = 20
                factors.controlOfOwnTrap = 10
                if(strategy.urgency){
                    factors.guardOwnTrap = 200
                    factors.controlOfOpponentsTrap = 300
                }
            }
            return factors;
        },
        evaluateBoard(squares, color, isMaximizingPlayer) {
            const piecePowers = {
                mouse: 8,
                cat: 5,
                dog: 6,
                monkey: 7,
                leopard: 10,
                tiger: 15,
                lion: 25,
                elephant: 20,
            };
            const factors = this.getBoardFactors(squares,color)
            const ownTeamColor = color;
            const opponentTeamColor = this.getOpponentColor(color);
            const trapCodes = {
                black: ["C9", "D8", "E9"],
                white: ["C1", "D2", "E1"],
            };
            const trapGuardCodes = {
                black: ["B9", "C8", "D7", "E8", "F9"],
                white: ["C2", "B1", "D3", "E2", "F1"],
            };
            const houseCodes = {
                black: "D9",
                white: "D1",
            };
            const score = {
                white: {
                    pieceValue: 0,
                    pieceMobility: 0,
                    controlledSquares: 0,
                    opponentsControlledSquares: 0,
                    controlOfOwnTraps: 0,
                    controlOfOpponentsTraps: 0,
                    winFactor: 0,
                },
                black: {
                    pieceValue: 0,
                    pieceMobility: 0,
                    controlledSquares: 0,
                    opponentsControlledSquares: 0,
                    controlOfOwnTraps: 0,
                    controlOfOpponentsTraps: 0,
                    winFactor: 0,
                },
            };
            let highestAnimalRows = {
                black: 0,
                white: 0,
            };
            squares.forEach((row) => {
                row.forEach((square) => {
                    const { piece, color: squareColor } = square.content;
                    if (piece) {
                        score[squareColor].controlledSquares +=
                            factors.controlOfSquare;
                        const opponentsColor =
                            this.getOpponentColor(squareColor);
                        const piecePower = piecePowers[piece];
                        score[squareColor].pieceValue += piecePower;
                        score[squareColor].pieceMobility +=
                            this.getPossibleMoves(
                                square.row,
                                square.col,
                                squares
                            ).length;
                        if (
                            squareColor === "black" &&
                            square.row > highestAnimalRows.black
                        ) {
                            highestAnimalRows.black = square.row;
                        } else if (
                            squareColor === "white" &&
                            8 - square.row > highestAnimalRows.white
                        ) {
                            highestAnimalRows.white = 8 - square.row;
                        }
                        if (
                            square.areaColor &&
                            squareColor !== square.areaColor
                        ) {
                            score[squareColor].opponentsControlledSquares +=
                                factors.controlOfOpponentsSquare;
                        }
                        if (trapCodes[squareColor].includes(square.code)) {
                            score[squareColor].controlOfOwnTraps +=
                                factors.controlOfOwnTrap;
                        } else if (
                            trapCodes[opponentsColor].includes(square.code) &&
                            (!this.trapIsSafe(squares, square.code) ||
                                !isMaximizingPlayer)
                        ) {
                            score[squareColor].controlOfOpponentsTraps +=
                                factors.controlOfOpponentsTrap;
                        } else if (houseCodes[opponentsColor] === square.code) {
                            score[squareColor].winFactor += factors.winFactor;
                        } else if (
                            trapGuardCodes[ownTeamColor].includes(square.code)
                        ) {
                            score[squareColor].controlOfOpponentsTraps +=
                                factors.guardOwnTrap;
                        } else if (
                            trapGuardCodes[opponentsColor].includes(square.code)
                        ) {
                            score[squareColor].controlOfOpponentsTraps +=
                                factors.guardOpponentsTrap;
                        }
                    }
                });
            });
            const ownScore =
                score[ownTeamColor].pieceValue +
                score[ownTeamColor].pieceMobility +
                score[ownTeamColor].controlledSquares +
                score[ownTeamColor].opponentsControlledSquares +
                score[ownTeamColor].controlOfOwnTraps +
                score[ownTeamColor].controlOfOpponentsTraps +
                score[ownTeamColor].winFactor +
                highestAnimalRows[ownTeamColor] * factors.attack;
            const opponentScore =
                score[opponentTeamColor].pieceValue +
                score[opponentTeamColor].pieceMobility +
                score[opponentTeamColor].controlledSquares +
                score[opponentTeamColor].opponentsControlledSquares +
                score[opponentTeamColor].controlOfOwnTraps +
                score[opponentTeamColor].controlOfOpponentsTraps +
                score[opponentTeamColor].winFactor +
                highestAnimalRows[opponentTeamColor] * factors.attack;
            return ownScore - opponentScore;
        },
        isWin(board, color) {
            let row,
                col = 3;
            if (color === "white") row = 0;
            else row = 8;
            return board[row][col].content.piece;
        },
        getBoardPossibleMoves(board, color) {
            const moves = [];
            for (let row = 0; row < board.length; row++) {
                for (let col = 0; col < board[row].length; col++) {
                    const square = board[row][col];
                    if (
                        square.content.piece &&
                        square.content.color === color
                    ) {
                        let possibleMoves = this.getPossibleMoves(row, col);
                        for (let k = 0; k < possibleMoves.length; k++) {
                            moves.push(possibleMoves[k]);
                        }
                    }
                }
            }
            return moves;
        },
        getOpponentColor(color) {
            return { black: "white", white: "black" }[color];
        },
    },
};
</script>

<style lang="scss">
.chessboard {
    padding-bottom: 97.5%;
}
.holding-piece {
    pointer-events: none;
}
.notation {
    fill: #ccc;
    font-size: 1.5rem;
}
</style>
