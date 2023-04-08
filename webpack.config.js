const path = require('path');

module.exports = {
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.resolve('resources/js'),
            '@layout': path.resolve('resources/js/components/layout'),
            '@modules': path.resolve('resources/js/store/modules'),
            '@partials': path.resolve('resources/js/components/_partials'),
            '@mixins': path.resolve('resources/js/components/_mixins'),
            '@auth': path.resolve('resources/js/components/auth'),
        },
    },
};
