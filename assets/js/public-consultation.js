$(() => {
    $('#create-public-consultation-form').on('submit', function (event) {
        event.preventDefault()

        $.ajax({
            type: "POST",
            url: MapasCulturais.createUrl('consulta-publica', 'store'),
            data: {
                title: $("[name='title']").val(),
                subtitle: $("[name='subtitle']").val(),
                google_docs_link: $("[name='google_docs_link']").val(),
            },
            dataType: "json",
            success(res) {
                successAlert(res.message)
            },
            error(err) {
                let message = 'Ocorreu algum erro. Verifique e tente novamente.'
                let cssClass = 'danger'

                if (err.status === 400) {
                    message = err.responseJSON.message
                    cssClass = 'warning'
                }

                errorAlert(message, cssClass)
            }
        })
    })
})

const errorAlert = (message, cssClass) => {
    $('#create-public-consultation-alerts')
        .text(message)
        .addClass(cssClass)
        .fadeIn("slow")

    setTimeout(() => {
        $('#create-public-consultation-alerts')
            .hide()
            .empty()
            .removeClass(cssClass)
    }, 4000)
}

const successAlert = (message) => {
    const url = MapasCulturais.createUrl('consulta-publica', 'index')

    $('#create-public-consultation-alerts')
        .empty()
        .text(message)
        .removeClass('warning danger')
        .addClass('success')
        .fadeIn("slow")

    setTimeout(() => {
        window.location.replace(url)
    }, 2000)
}
