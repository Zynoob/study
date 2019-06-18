module.exports = {
    lintOnSave: false,
    devServer: {
    proxy: {
        '/api': {
            target: 'http://localhost/api/',  // target host
            ws: true,  // proxy websockets 
            changeOrigin: true,  // needed for virtual hosted sites
            pathRewrite: {
                '^/api': '/'  // rewrite path
            }
        },
    }
}
}
