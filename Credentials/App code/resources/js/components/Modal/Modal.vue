<template>
    <div v-show="open" class="allineatore2">
        <div class="modal d-flex main_modal align-items-center modal-outgame" :style="{background: modalBackground}">
            <div class="modal-content container-sm d-flex flex-column align-items-center">
                <div class="d-flex container-sm align-items-center justify-content-between flex-row">
                    <img class="modal_logo" src="../../../images/extra_objects/ddd.jpg">
                    <span class="version_sign">v 1.0.6</span>
                </div>
                <div v-if="checkGameStatus" class="console-screen d-flex justify-content-center align-items-center">
                    <p  class="main_message" >
                        <span v-html="mainMessage" :class="finishedText ? 'blink-text' : ''" :style="{fontSize: gameFinished ? '25px' : '17px', color: finishedText ?? finishedText}"></span>
                    </p>
                </div>
                <div v-if="!canStart" class="console-screen d-flex justify-content-center align-items-center">
                    <p  class="main_message">
                        <span >Your Game Will Start in {{timeoutIndicator}}</span>
                    </p>
                </div>
                <template v-if="(this.gameStarted && this.canStart) || startNewGame">
                    <div class="d-flex flex-wrap flex-column justify-content-center" :style="{paddingTop : checkGameStatus ? 0 : '30px'}">
                        <div v-if="showNotification" class="notification">
                          Room ID copied to clipboard!
                        </div>
                        <div class="mb-3" v-for="(item, index) in buttons" :key="index">
                            <Button
                                v-on:handelClick="() => item.onclick(item.params ?? '')"
                                :title="item.title"
                                :icons="item.icon"
                                :image="item.image"
                            />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
import Button from "../Button/Button.vue";
import store from "../../store";
import passMessages from "../../constants/gameMode"
export default {
    props: {
        open: Boolean,
        gameStarted: Boolean,
        message: {
            type: String,
        },
        delay: {
            type: Boolean,
            default: true
        },
        readyToStart: {
            type: Boolean,
            default: false
        },
        startNewGame: {
            type: Boolean,
            default: false
        },
        showNotification: {
            type: Boolean,
            default: false
        },
        buttons: {
            type: Array,
            default: [],
        },
        nftSunflowerPoints: {
            type: Number,
            default: 0
        },
        gameModeLevel: {
            type: Number,
            default: 0
        },
        game: {}
    },
    components: { Button },
    data () {
        return {
            canStart:this.delay,
            timeoutIndicator: null,
            gameFinished: false,
            finishedText: null,
        }
    },
    computed: {
        checkGameStatus(){
            return ((this.game?.status !== 'started') && (!this.gameStarted)) || this.message
        },
        modalBackground() {
          if(!this.message){
            if(this.gameStarted && this.canStart){
              return 'transparent';
            }
          }
        },
        user() {
            return store.state.user
        },
        mainMessage(){
            if (this.gameStarted && !this.canStart) {
                return 'CountDown Message'
            }

            if (this.user && !this.message) {
                let copy = `${passMessages[this.gameModeLevel]} required...`

                if (this.nftSunflowerPoints >= this.gameModeLevel) {
                    copy += ' <span style="color: green;">You can play</span>'
                } else {
                    copy += ' <span style="color: #ee3635;">You can\'t play</span>'
                }
                return copy
            }
           if(this.message){
               this.gameFinished = true;
           }
           if (this.message){
               this.finishedText = this.message === 'You Lose' ? 'red' : 'green';
           }
            return this.message
                ? this.message
                : 'Login required' + ' <i class="fa-solid fa-bars"></i>' + ' <i class="fa-solid fa-power-off"></i>'
        },
    },
    created() {
        if(this.gameStarted && !this.canStart && this.user){
            let timeout = 4
            let interval = setInterval(() => {
                this.timeoutIndicator = this.numberToTime(timeout)
                if(!timeout){
                    clearInterval(interval)
                    this.canStart = true
                    this.closeModal();
                    this.$emit("handelReadyToStart")
                }
                timeout --;
            },1000)
        }
    },
    watch: {
        user: function (value){
            if(value){
                let timeout = 4
                let interval = setInterval(() => {
                    this.timeoutIndicator = this.numberToTime(timeout)
                    if(!timeout){
                        clearInterval(interval)
                        this.canStart = true
                        this.closeModal();
                        this.$emit("handelReadyToStart")
                    }
                    timeout --;
                },1000)
            }
        },
    },
    methods: {
        numberToTime(time){
            let minutes = Math.floor(time/60);
            minutes = minutes < 10 ? '0' + minutes : minutes
            let seconds = time % 60
            seconds = seconds < 10 ? '0' + seconds : seconds
            return minutes + ':' + seconds

        },
        closeModal() {
            this.$emit("closeModal")
        },
        quitGame() {
            this.$emit("quitGame")
        }
    },
}
</script>

<style lang="scss">

@keyframes blink {
    0% { opacity: 0; }
    35% { opacity: 0; }
    36% { opacity: 1; }
    100% { opacity: 1; }
}

.blink-text {
    animation: blink 0.4s infinite;
}

.notification {
  position: fixed;
  right: 20px;
  top:20px;
  background-color: #4caf50;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

.gameStarted-wrapper{
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.modal-ingame{
    background:
        linear-gradient(
                rgba(0, 0, 0, 0.4),
                rgba(0, 0, 0, 0.4)
        );
}
.modal-outgame{
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(/images/bignilo3.jpg?f59feddceecdafca8ecaff8ca2dd9179);
    background-repeat: repeat;
    background-position: center;
    background-size: 600px;
}
.main_modal {
    .modal_logo {
        width:80px
    }
    .version_sign {
        color: white;
        margin-top: 5px;
    }
    .main_message {
        padding: 10px;

        & > span {
            color: white;
            font-size: 17px;
            .fa-bars {
                margin-top: 0;
                margin-left: 0;
                position: static;
                font-size: inherit;
            }
            .fa-power-off {
            }
            img {
                width: auto;
                height: 1em;
            }
        }
    }
}
</style>
