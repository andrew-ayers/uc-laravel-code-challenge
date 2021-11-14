import Owners from './components/Owners.vue';
import Addresses from './components/Addresses.vue';
import Cars from './components/Cars.vue';

import OwnerViewEdit from './components/OwnerViewEdit.vue';
import AddressViewEdit from './components/AddressViewEdit.vue';
import CarViewEdit from './components/CarViewEdit.vue';

// Ref: https://router.vuejs.org/guide/essentials/dynamic-matching.html

export const routes = [
    {
        name: 'owners',
        path: '/owners',
        component: Owners
    },
    {
        name: 'addresses',
        path: '/addresses',
        component: Addresses
    },
    {
        name: 'cars',
        path: '/cars',
        component: Cars
    },
    {
        name: 'owner',
        path: '/owner/:id',
        component: OwnerViewEdit
    },
    {
        name: 'address',
        path: '/address/:id',
        component: AddressViewEdit
    },
    {
        name: 'car',
        path: '/car/:id',
        component: CarViewEdit
    }
];
