/*
|--------------------------------------------------------------------------
| Javascript > Constants
|--------------------------------------------------------------------------
|
| A file that manages all the constants properties to be used in whole application
|
*/
'use strict';
import { required, requiredIf } from '@vuelidate/validators'
export const gameBoard = [
    ['', '', ''],
    ['', '', ''],
    ['', '', '']
];
function createGameForm() {
    return {
        form: {
            player_one: "",
            player_two: "",
            is_computer: false,
        },
        get rules() {
            return {
                player_one: { required },
            };
        },
    };
}
export const gameForm = createGameForm();
export default {
    gameBoard,
    gameForm
}
