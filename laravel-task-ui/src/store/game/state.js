/*
|--------------------------------------------------------------------------
| Store > Game > State
|--------------------------------------------------------------------------
|
| This file contains the state property of Auth Vuex Module
|
| You may freely extend this store file if the store file that you will
| be building has similar characteristics.
|
*/
'use strict';
import { gameBoard, gameForm }  from '@/js/constants'
export default {
    board: gameBoard,
    gameComplete: false,
    form: gameForm.form,
    rules: gameForm.rules,
    players: [],
}
