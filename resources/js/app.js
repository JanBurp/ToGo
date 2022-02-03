require('./bootstrap');

import { createApp, h } from 'vue';

import TogoHome from './Togo/TogoHome.vue';

createApp(TogoHome).mount('#app');



// import { createInertiaApp } from '@inertiajs/inertia-vue3';
// import { InertiaProgress } from '@inertiajs/progress';

// const appName = 'ToGo';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => require(`./Pages/${name}.vue`),
//     setup({ el, app, props, plugin }) {
//         return createApp({ render: () => h(app, props) })
//             .use(plugin)
//             .mixin({ methods: { route } })
//             .mount(el);
//     },
// });

// InertiaProgress.init({ color: '#4B5563' });
