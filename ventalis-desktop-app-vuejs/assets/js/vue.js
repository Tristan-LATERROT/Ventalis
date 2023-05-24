
const Home = {
    template: '#home',
    name: 'Home'
}
const UserSettings = {
    template: '#user',
    name: 'UserSettings'
}
const Orders = {
    template: '#orders',
    name: 'Orders',
    data: () => {
        return {
            orders,
        }
    }
}
const OrderDetails = {
    template: '#orderDetails',
    name: 'OrdersDetails'
}

// router
const router = VueRouter.createRouter({
        history: VueRouter.createWebHashHistory(),
        routes: [
            {path: '/', component : Home, name: 'Home'},
            {path: '/user-settings', component : UserSettings, name : 'UserSettings'},
            {path: '/orders', component : Orders, name : 'Orders'},
            {path: '/order-details', component : OrderDetails, name : 'OrderDetails'},
        ]
})

const app = Vue.createApp({})
app.use(router)
app.mount('#app')