<script setup>
import {ref, computed, watch} from 'vue';
import { useStore } from 'vuex';
import { useVuelidate } from '@vuelidate/core';

const store = useStore();
const isOpen = ref(false);
const isModalVisible = computed(() => isOpen.value);
const player = ref('X');
const board = computed(() => store.getters['game/getBoard']);
const isGameStarted = computed(() => store.getters['game/getGameStatus']);
const form = computed(() => store.getters['game/getForm']);
const isComputer = ref(false);
const v$ = useVuelidate(store.getters['game/getRules'], store.getters['game/getForm']);
const CalculateWinner = (board) => {
    const lines = [[0, 1, 2], [3, 4, 5], [6, 7, 8], [0, 3, 6], [1, 4, 7], [2, 5, 8], [0, 4, 8], [2, 4, 6]]

    for (let i = 0; i < lines.length; i++) {
        const [a, b, c] = lines[i]

        if (board[a] && board[a] === board[b] && board[a] === board[c]) {
            return board[a]
        }
    }

    return null
}

const winner = computed(() => CalculateWinner(board.value.flat()))

const MakeMove = (x, y) => {
    if (winner.value) return

    if (board.value[x][y]) return

    board.value[x][y] = player.value

    player.value = player.value === 'X' ? 'O' : 'X'
}

const ResetGame = () => {
    board.value = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ]
    player.value = 'X'
}
const onToggle = () => {
    store.dispatch('game/startGame', true)
    isOpen.value = !isOpen.value;
}
const submit = async () => {
    const validation = await v$.value.$validate();
    if(!validation) return;
    let formData = {
        ...form,
    };
    let players = [form.value.player_one];
    if(!form.value.is_computer && form.value.player_two !== ""){
        players.push(form.value.player_two);
    }
   formData = {...formData, players }
    store.dispatch('game/startGame',formData)
}
const updateIsComputer = async () => {
    isComputer.value = !isComputer.value;
}

</script>

<template>
    <div class="flex items-center justify-center h-screen" v-if="!isGameStarted">
        <button
            class="px-4 py-2 bg-pink-500 rounded uppercase font-bold hover:bg-pink-600 duration-300"
            @click="onToggle"
        >
            Start Game
        </button>
    </div>
    <transition name="fade">
        <div v-if="isModalVisible" class="flex items-center justify-center h-screen">
            <div
                class="w-full max-w-lg p-3 mx-auto my-auto rounded-xl shadow-lg bg-white"
            >
                <div>
                    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                                Player1 Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" type="text" placeholder="Enter player 1 name" v-model="form.player_one"  v-error="v$.player_one.$error">
                            <di v-if="v$.player_one.$errors.length">
                                <p class="text-red-500 text-xs italic">{{v$.player_one.$errors[0].$message }}</p>
                            </di>
                        </div>
                        <div class="mb-6" v-if="!isComputer">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                                Player2 Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" type="text" placeholder="Enter player 2 name" v-model="form.player_two">
                        </div>
                        <div class="mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 block text-gray-500 font-bold">
                                <input class="mr-2 leading-tight" type="checkbox" v-model="form.is_computer" @change="updateIsComputer()">
                                <span class="text-sm">
                                    Play with computer
                                </span>
                            </label>
                        </div>
                    </form>
                    <div class="p-3 mt-2 text-center space-x-4 md:block">
                        <button
                            class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
                            @click="submit"
                        >
                            Save
                        </button>
                        <button
                            @click="onToggle"
                            class="mb-2 md:mb-0 bg-purple-500 border border-purple-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg hover:bg-purple-600"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <!--    <main class="pt-8 text-center">-->
    <!--        <h1 class="mb-8 text-3xl font-bold uppercase">Tic Tac Toe</h1>-->

    <!--        <h3 class="text-xl mb-4">Player {{ player }}'s turn</h3>-->

    <!--        <div class="flex flex-col items-center mb-8">-->
    <!--            <div-->
    <!--                v-for="(row, x) in board"-->
    <!--            :key="x"-->
    <!--            class="flex">-->
    <!--            <div-->
    <!--                v-for="(cell, y) in row"-->
    <!--            :key="y"-->
    <!--            @click="MakeMove(x, y)"-->
    <!--            :class="`border border-white w-24 h-24 hover:bg-gray-700 flex items-center justify-center material-icons-outlined text-4xl cursor-pointer ${cell === 'X' ? 'text-pink-500' : 'text-blue-400'}`">-->
    <!--            {{ cell === 'X' ? 'close' : cell === 'O' ? 'circle' : '' }}-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="text-center">-->
    <!--    <h2 v-if="winner" class="text-6xl font-bold mb-8">Player '{{ winner }}' wins!</h2>-->
    <!--    <button @click="ResetGame" class="px-4 py-2 bg-pink-500 rounded uppercase font-bold hover:bg-pink-600 duration-300">Reset</button>-->
    <!--</div>-->
    <!--</main>-->
</template>

<style>
body {
    @apply bg-gray-800 text-white;
}
</style>
