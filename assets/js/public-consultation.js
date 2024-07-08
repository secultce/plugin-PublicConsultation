const publicConsultation = {
    researchText: '',
    mountSearchResult(searchResult) {
        const html = searchResult.map(publicConsultation => {
            return `
                <article class="objeto clearfix" id="public-consultation-wrapper">
                    <h1>
                        <a href="">
                            ${publicConsultation.title}
                        </a>
                    </h1>
                    <div class="objeto-meta">
                        <span class="label">
                            ${publicConsultation.subtitle}
                        </span>
                    </div>
                    <div class="objeto-meta">
                        <span class="label" style="word-wrap: break-word;">
                            <a href="${publicConsultation.google_docs_link}" target="_blank">
                                ${publicConsultation.google_docs_link}
                            </a>
                        </span>
                    </div>
                    <div class="entity-actions">
                        <a class="btn btn-small btn-primary" href="${MapasCulturais.createUrl('consulta-publica', 'edit', { 'id': publicConsultation.id })}">
                            editar
                        </a>
                        <button class="btn btn-small btn-danger" del-public-consultation-btn data-public-consultation-id="${publicConsultation.id}">
                            excluir
                        </button>
                    </div>
                </article>`
        }).join('')

        return html
    },
    showSearchResult(statusLabel, searchHtml) {
        $(`#${statusLabel}-wrapper`).empty()
        $(`#${statusLabel}-wrapper`).html(searchHtml)

        $('#spinner-search').addClass('d-none')
    }
}

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
                        defaultErrorMessage()
                    }
                })
            }
        })
    })

    $('[search-input]').on('keyup', function (event) {
        // Ignora algumas teclas (tab, shift, ctrl) para que não seja feita requisição ao clicá-las
        const keyCode = event.keyCode
        if (event.ctrlKey || (keyCode >= 9 && keyCode <= 45) || (keyCode >= 91 && keyCode <= 93) || (keyCode >= 112 && keyCode <= 145)) return

        // Remove todos os eventos do input para que não aconteça requisição a cada digitação
        $(this).each(function () {
            $(this).data('events', $.extend(true, {}, $._data(this, 'events')))
        })
        $(this).off()

        $('#spinner-search').removeClass('d-none')

        // Espera 1 segundo após a digitação para realizar a requisição
        setTimeout(() => {
            const status = parseInt(event.currentTarget.dataset.status)
            const statusLabel = status === 1 ? 'published' : 'unpublished'
            publicConsultation.researchText = $(this).val()

            if (publicConsultation.researchText.length) {
                // Se tiver texto no input, retorna o resultado da consulta baseado no texto
                $.ajax({
                    type: "GET",
                    url: MapasCulturais.createUrl('consulta-publica', 'search'),
                    data: {
                        status,
                        text: publicConsultation.researchText,
                    },
                    dataType: "json",
                    success(res) {
                        const notFoundElement = '<h4 class="search-not-found">Pesquisa não encontrada</h4>'
                        const searchHtml = res.length ? publicConsultation.mountSearchResult(res) : notFoundElement

                        publicConsultation.showSearchResult(statusLabel, searchHtml)
                    },
                    error() {
                        $('#spinner-search').addClass('d-none')

                        defaultErrorMessage()
                    }
                })
            } else {
                // Caso o input seja esvaziado, a busca retornará todas as consultas públicas daquele status
                $.ajax({
                    type: "GET",
                    url: MapasCulturais.createUrl('consulta-publica', 'allByStatus'),
                    data: {
                        status,
                    },
                    dataType: "json",
                    success(res) {
                        const searchHtml = publicConsultation.mountSearchResult(res)

                        publicConsultation.showSearchResult(statusLabel, searchHtml)
                    },
                    error() {
                        $('#spinner-search').addClass('d-none')

                        defaultErrorMessage()
                    }
                })
            }

            // Adiciona os eventos novamente ao input
            $(this).each(function () {
                let $self = $(this)
                $.each($(this).data('events'), function (_, e) {
                    $self.on(e[0].type, e[0].handler)
                })
            })
        }, 1000)
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

const defaultErrorMessage = () => {
    const message = 'Ocorreu algum erro. Verifique e tente novamente.'
    const cssClass = 'danger'

    errorAlert(message, cssClass)
}
