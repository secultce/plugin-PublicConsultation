$(() => {
    $('#create-public-consultation-form, #edit-public-consultation-form').on('submit', event => {
        event.preventDefault()

        $.ajax({
            type: "POST",
            url: MapasCulturais.createUrl('consulta-publica', event.currentTarget.dataset.action),
            data: getData(event),
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

    $('#del-public-consultation-btn').on('click', (event) => {
        Swal.fire({
            title: "Deletar Consulta Pública?",
            text: "Essa ação não poderá ser desfeita.",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar",
            reverseButtons: true
        }).then(res => {
            if (res.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: MapasCulturais.createUrl('consulta-publica', 'delete'),
                    data: {
                        id: event.currentTarget.dataset.publicConsultationId
                    },
                    dataType: "json",
                    success(res) {
                        $(event.currentTarget).parents('#public-consultation-wrapper').remove()

                        successAlert(res.message)
                    },
                    error() {
                        const message = 'Ocorreu algum erro. Verifique e tente novamente.'
                        const cssClass = 'danger'

                        errorAlert(message, cssClass)
                    }
                })
            }
        })
    })
})

const errorAlert = (message, cssClass) => {
    $('.public-consultation-alerts')
        .text(message)
        .addClass(cssClass)
        .fadeIn("slow")

    setTimeout(() => {
        $('.public-consultation-alerts')
            .hide()
            .empty()
            .removeClass(cssClass)
    }, 4000)
}

const successAlert = (message) => {
    const url = MapasCulturais.createUrl('consulta-publica', 'index')

    $('.public-consultation-alerts')
        .empty()
        .text(message)
        .removeClass('warning danger')
        .addClass('success')
        .fadeIn("slow")

    setTimeout(() => {
        window.location.replace(url)
    }, 2000)
}

const getData = (event) => {
    let data = {
        title: $("[name='title']").val(),
        subtitle: $("[name='subtitle']").val(),
        google_docs_link: $("[name='google_docs_link']").val(),
    }

    if (event.currentTarget.dataset.action === 'update') {
        data.id = event.currentTarget.dataset.publicConsultationId
        data.status = $("[name='status']").val()
    }

    return data
}
