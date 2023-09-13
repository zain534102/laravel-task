/*
|--------------------------------------------------------------------------
| Store > Game > Mutations
|--------------------------------------------------------------------------
|
| This file contains the mutations property of Auth Vuex Module
|
| You may freely extend this store file if the store file that you will
| be building has similar characteristics.
|
*/
'use strict';

export default {
    changePosition: function (state,position){
        state.position = position;
    },
    startGame: function (state, newGameStatus){
        state.gameComplete = newGameStatus;
    },
    setPlayers: function (state, players){
        state.players = players;
    }
}
