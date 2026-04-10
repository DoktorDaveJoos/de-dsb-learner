import { createInertiaApp } from '@inertiajs/react';

createInertiaApp({
    title: (title) => (title ? `${title} - de-dsb Learner` : 'de-dsb Learner'),
    progress: {
        color: '#6b7280',
    },
});
