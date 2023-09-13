/*
|--------------------------------------------------------------------------
| Store > Game > Actions
|--------------------------------------------------------------------------
|
| This file contains the actions property of Auth Vuex Module
|
| You may freely extend this store file if the store file that you will
| be building has similar characteristics.
|
*/
'use strict';

export default {
    makeMove: function (){

    },
    startGame: function (context,payload){
        context.commit('setPlayers',payload.players)
        context.commit('startGame',payload);
    },
    addPlayer: function (context, payload){
        context.commit('setPlayers',payload)
    }
}
