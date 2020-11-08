const path = require('path')
const prefresh = require('@prefresh/vite')

const root = './assets'

/**
 * @type { import('vite').UserConfig }
 */
const config = {
    alias: {
        'react': 'preact/compat',
        'react-dom': 'preact/compat',
    },
    root,
    jsx: 'preact',
    plugins: [prefresh()],
    cors: true,
    emitManifest: true,
    configureServer: function ({ root, watcher }) {
        watcher.add(path.resolve(root, '../templates/**/*.twig'))
        watcher.on('change', function (path) {
            if (path.endsWith('.twig')) {
                watcher.send({
                    type: 'full-reload',
                    path
                })
            }
        })
    }
}

module.exports = config