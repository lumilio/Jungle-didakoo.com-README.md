import VueRouter from "vue-router";
import store from "../store";
import DefaultContainer from "../components/layouts/DefaultContainer.vue";
import RankPage from "../components/pages/RankPage.vue";
import AvatarPage from "../components/pages/AvatarPage.vue";
import BoardGame from "../components/pages/BoardGame.vue";
import InfoPage from "../components/pages/InfoPage.vue";
import MenuPage from "../components/pages/MenuPage.vue";
import PlayGame from "../components/pages/PlayGame.vue";
const authGuard = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        next();
    } else {
        next('/login');
    }
};
const throttleActivityLog = async (callback, minutes) => {
    const now = Math.floor(Date.now() / 1000);
    const lastActivityLogged = localStorage.getItem('lastActivityLogged') || 0;

    if (now - lastActivityLogged > minutes * 60) {
        console.log('IS LOGGING');
        try {
            const axios = require('axios');
            await axios.post(process.env.MIX_SERVER_APP_URL + '/api/update-player-last-activity', {
                headers: {
                    'Content-Type': 'application/json',
                    '_token': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            localStorage.setItem('lastActivityLogged', now);
        } catch (error) {
            console.error('Error updating player activity:', error);
        }
    } else {
        console.log('IS NOT LOGGING');
    }
};
const routes = [
    {
        path: '/',
        component: DefaultContainer,
        children: [
            { path: '', redirect: '/menu' },
            { path: 'rank', name: 'rank', component: RankPage },
            { path: 'avatar', name: 'avatar', component: AvatarPage },
            { path: 'menu', name: 'menu', component: MenuPage },
            { path: 'info', name: 'info', component: InfoPage }
        ]
    },
    { path: '/game', name: 'game', component: BoardGame },
    { path: '/room/:id', name: 'room', component: PlayGame },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});
router.beforeEach(async (to, from, next) => {
    if (store.state.user) {
        await throttleActivityLog(async () => {}, 1);
    }
    next();
});
export default router;
