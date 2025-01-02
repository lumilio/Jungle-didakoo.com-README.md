import {
    animals,
    waterCodes,
    trapCodes,
    houseCodes,
    highGuardCodes,
    lowGuardCodes,
    trapGuards,
    protectHouseCodes,
    initialState,
    boardColors,
    allowedColors
} from "./constants";
export default {
    getSquareCode(row, col) {
        let rowMapping = ["9", "8", "7", "6", "5", "4", "3", "2", "1"];
        let colMapping = ["A", "B", "C", "D", "E", "F", "G"];

        return colMapping[col] + rowMapping[row];
    },
    getIndexesByCode(code) {
        let rowMapping = ["9", "8", "7", "6", "5", "4", "3", "2", "1"];
        let colMapping = ["A", "B", "C", "D", "E", "F", "G"];
        return {
            rowIndex: rowMapping.indexOf(code[1]),
            colIndex: colMapping.indexOf(code[0]),
        };
    },
    /**
     * Get a square color based on given row and column index
     * @param {Number} row
     * @param {Number} col
     * @returns {String}
     */
    getSquareColor(row, col) {
        if (
            row > 2 &&
            row < 6 &&
            col !== 0 &&
            col !== 3 &&
            col !== 6
        )
            return "dark";
        else return "light";
    },

    /**
     * Get Square Position Coordinate (x,y)
     * @param row
     * @param col
     * @param option
     * @returns {{x: *, y: number}}
     */
    getSquarePosition(row, col, option = {}) {
        return {
            x: col * option.square.width + option.padding,
            y: row * option.square.height,
        };
    },

    /**
     * Get chess piece mapped by square code.
     * @param {String} squareCode
     * @returns {String} The chess piece name
     */
    getInitialRandomState() {
        const indexes = [0, 1, 2, 3, 4, 5, 6, 7];
        const whiteIndexes = [...indexes].sort((a, b) => 0.5 - Math.random());
        const blackIndexes = [...indexes].sort((a, b) => 0.5 - Math.random());

        const animalTypes = [
            "tiger",
            "lion",
            "cat",
            "dog",
            "elephant",
            "monkey",
            "leopard",
            "mouse"
        ]
        const res = {}
        let blackCodes = [
            "A9", "G9", "B8", "F8",
            "A7", "C7", "E7", "G7"
        ]
        let whiteCodes = [
            "A1", "G1", "B2", "F2",
            "A3", "C3", "E3", "G3"
        ]
        for (let i = 0; i < 8; i++){
            res[blackCodes[i]] = {
                color: "black",
                piece: animalTypes[blackIndexes[i]]
            }
            res[whiteCodes[i]] = {
                color: "white",
                piece: animalTypes[whiteIndexes[i]]
            }
        }
        return res;
    },

    /**
     * Get knight possible moves indexes
     * @param {Number} squareRowIndex
     * @param {Number} squareColIndex
     * @returns
     */
    getKnightPossibleMoves(squareRowIndex, squareColIndex) {
        return [
            { rowIndex: squareRowIndex, colIndex: squareColIndex + 1 },
            { rowIndex: squareRowIndex, colIndex: squareColIndex - 1 },

            { rowIndex: squareRowIndex - 1, colIndex: squareColIndex },
            { rowIndex: squareRowIndex + 1, colIndex: squareColIndex },
        ];
    },

    getAnimalPowers(){
        return animals
    },
    getWaterCodes (){
        return waterCodes;
    },
    getTrapCodes() {
        return trapCodes
    },
    getHouseCodes(){
        return houseCodes
    },
    getHighGuardCodes(){
        return highGuardCodes
    },
    getLowGuardCodes(){
        return lowGuardCodes
    },
    getTrapGuards(){
        return trapGuards
    },
    getProtectHouseCodes(){
        return protectHouseCodes
    },
    getInitialState(){
        return this.getInitialRandomState()
    },
    getBoardColors(){
        return boardColors
    },
    getAllowedColors(){
        return allowedColors
    }
};
