$(() => {
    $('#create-public-consultation-form, #edit-public-consultation-form').on('submit', event => {
        event.preventDefault()

        $('#create-public-consultation-btn, #edit-public-consultation-btn').attr("disabled", true)

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

                // Ocorre na validação do back-end dos campos obrigatórios
                if (err.status === 400) {
                    message = err.responseJSON.message
                    cssClass = 'warning'
                }

                errorAlert(message, cssClass)

                $('#create-public-consultation-btn, #edit-public-consultation-btn').attr("disabled", false)
            }
        })
    })

    $('[del-public-consultation-btn]').on('click', (event) => {
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
                    url: MapasCulturais.createUrl('consulta-publica', 'trash'),
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

    $('[search-input]').on('keyup', (event) => {
        const keyCode = event.keyCode

        // Ignora algumas teclas (tab, shift, ctrl) para que não seja feita requisição ao clicá-las
        if ((keyCode >= 9 && keyCode <= 45) || (keyCode >= 91 && keyCode <= 93) || (keyCode >= 112 && keyCode <= 145)) return

        const status = parseInt(event.currentTarget.dataset.status)
        const statusLabel = status === 1 ? 'published' : 'unpublished'
        const text = event.currentTarget.value

        if (text.length) {
            $.ajax({
                type: "GET",
                url: MapasCulturais.createUrl('consulta-publica', 'search'),
                data: {
                    status,
                    text,
                },
                dataType: "json",
                success(res) {
                    console.log('requisição')
                    const notFoundElement = '<h4 style="text-align: center; margin: 40px 0 0;">Pesquisa não encontrada</h4>'
                    const searchHtml = res.length ? mountSearchResult(res) : notFoundElement

                    $(`#${statusLabel}-wrapper`).empty()
                    $(`#${statusLabel}-wrapper`).html(searchHtml)
                },
                error() {
                    // 
                }
            })
        } else {
            $.ajax({
                type: "GET",
                url: MapasCulturais.createUrl('consulta-publica', 'allByStatus'),
                data: {
                    status,
                },
                dataType: "json",
                success(res) {
                    console.log('requisição')
                    const searchHtml = mountSearchResult(res)

                    $(`#${statusLabel}-wrapper`).empty()
                    $(`#${statusLabel}-wrapper`).html(searchHtml)
                },
                error() {
                    // 
                }
            })
        }
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

const mountSearchResult = (searchResult) => {
    const html = searchResult.map(value => {
        return `
            <article class="objeto clearfix" id="public-consultation-wrapper">
                <h1>
                    <a href="">
                        ${value.title}
                    </a>
                </h1>
                <div class="objeto-meta">
                    <span class="label">
                        ${value.subtitle}
                    </span>
                </div>
                <div class="objeto-meta">
                    <span class="label" style="word-wrap: break-word;">
                        <a href="${value.google_docs_link}" target="_blank">
                            ${value.google_docs_link}
                        </a>
                    </span>
                </div>
                <div class="entity-actions">
                    <a class="btn btn-small btn-primary" href="${MapasCulturais.createUrl('consulta-publica', 'edit', { 'id': value.id })}">
                        editar
                    </a>
                    <button class="btn btn-small btn-danger" del-public-consultation-btn data-public-consultation-id="${value.id}">
                        excluir
                    </button>
                </div>
            </article>`
    }).join('')

    return html
}
