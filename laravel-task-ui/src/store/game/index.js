/*
|--------------------------------------------------------------------------
| Store > Game
|--------------------------------------------------------------------------
|
| A Class file that manages all the properties and abilities in relation
| to game
|
| You may freely extend this store file if the store file that you will
| be building has similar characteristics.
|
*/
'use strict';

import state from './state';
import getters from './getters';
import mutations from './mutations';
import actions from './actions';

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}; // End of export default
