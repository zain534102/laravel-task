import { createStore } from 'vuex';
import game from "@/store/game/index.js";
export default createStore({
    modules:{
        game: game
    }
})
