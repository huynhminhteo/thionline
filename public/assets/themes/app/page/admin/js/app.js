window.onload = function () {
    const ui = SwaggerUIBundle({
        dom_id: '#swagger-ui',
        url: url,
        operationsSorter: operationsSorter,
        configUrl: configUrl,
        validatorUrl: validatorUrl,
        oauth2RedirectUrl: oauth2RedirectUrl,

        requestInterceptor: function (request) {
            request.headers['X-CSRF-TOKEN'] = token;
            return request;
        },
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
    })

    window.ui = ui
}