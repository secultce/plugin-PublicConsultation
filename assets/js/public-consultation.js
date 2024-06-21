$(() => {
    $('#create-public-consultation-form').on('submit', function (event) {
        event.preventDefault()

        $('#create-public-consultation-alert-success').fadeIn("slow")

        setTimeout(() => {
            $(this).unbind('submit').submit()
        }, 1500)

    })
})
