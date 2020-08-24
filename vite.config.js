const path = require('path')
const cors = require('@koa/cors')
const root = './assets'

/**
 * @type { import('vite').UserConfig }
 */
const config = {
    root,
    configureServer: function ({ root, app, watcher }) {
        watcher.add(path.resolve(root, '../templates/**/*.twig'))
        watcher.on('change', function (path) {
            if (path.endsWith('.twig')) {
                watcher.send({
                    type: 'full-reload',
                    path
                })
            }
        })
        console.log(app)
        app.use(cors({ origin: '*' }))
    }
}

module.exports = config