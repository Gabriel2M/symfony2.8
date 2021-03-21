// global tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// global toast
$('.toast').toast('show')

// modal confirmation
$('form[modal-confirmation]').submit(function (event) {
    let $form = $(this),
        $modal = $('#confirmationModal')

    if ($modal.data('result') !== 'confirm') {
        $modal.find(".confirmation-modal-message")
            .text($form.attr('modal-confirmation'))

        $modal.find('.btn.confirm').off('click').click(function () {
            $modal.data('result', 'confirm')
            $form.find('.btn[type="submit"]').attr('disabled', 'disabled')
            $form.submit()
        })

        $modal.modal('show')

        return false
    }

    return true
})