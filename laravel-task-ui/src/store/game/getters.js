/*
|--------------------------------------------------------------------------
| Store > Game > Getters
|--------------------------------------------------------------------------
|
| This file contains the getters property of Auth Vuex Module
|
| You may freely extend this store file if the store file that you will
| be building has similar characteristics.
|
*/
'use strict';

import state from "@/store/game/state.js";

export default {
    getBoard: (state) => state.board,
    getGameStatus: (state) => state.gameComplete,
    getForm: (state) => state.form,
    getRules: (state) => state.rules,
    getPlayers: (state) => state.players,
}
