document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Add Prescription
    |--------------------------------------------------------------------------
    */

    const addToggle = document.getElementById(
        'mlAddPrescriptionToggle'
    );

    const addPanel = document.getElementById(
        'mlAddPrescriptionPanel'
    );

    const addCancel = document.getElementById(
        'mlAddPrescriptionCancel'
    );


    function setAddPanel(open) {

        if (!addPanel || !addToggle) {
            return;
        }

        addPanel.classList.toggle(
            'is-open',
            open
        );

        addToggle.setAttribute(
            'aria-expanded',
            open ? 'true' : 'false'
        );


        const icon = addToggle.querySelector('i');

        const label = addToggle.querySelector('span');


        if (icon) {

            icon.className = open
                ? 'bi bi-x-lg'
                : 'bi bi-plus-circle';
        }


        if (label) {

            label.textContent = open
                ? 'Cancel'
                : 'Add Prescription';
        }


        if (open) {

            setTimeout(function () {

                const firstInput =
                    addPanel.querySelector(
                        'input:not([type="hidden"]), select, textarea'
                    );

                if (firstInput) {
                    firstInput.focus();
                }

            }, 180);
        }
    }


    if (addToggle && addPanel) {

        addToggle.addEventListener(
            'click',
            function () {

                setAddPanel(
                    !addPanel.classList.contains(
                        'is-open'
                    )
                );
            }
        );
    }


    if (addCancel && addPanel) {

        addCancel.addEventListener(
            'click',
            function () {

                setAddPanel(false);
            }
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Edit Current Prescription
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-prescription-edit-toggle]'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const targetId =
                        button.dataset.target;

                    const panel =
                        document.getElementById(
                            targetId
                        );


                    if (!panel) {
                        return;
                    }


                    const open =
                        !panel.classList.contains(
                            'is-open'
                        );


                    panel.classList.toggle(
                        'is-open',
                        open
                    );


                    button.setAttribute(
                        'aria-expanded',
                        open ? 'true' : 'false'
                    );


                    const icon =
                        button.querySelector('i');


                    if (icon) {

                        icon.className = open
                            ? 'bi bi-x-lg'
                            : 'bi bi-pencil-square';
                    }


                    const textNodes =
                        Array.from(
                            button.childNodes
                        ).filter(
                            function (node) {

                                return (
                                    node.nodeType ===
                                    Node.TEXT_NODE
                                );
                            }
                        );


                    if (textNodes.length) {

                        textNodes[
                            textNodes.length - 1
                        ].textContent = open
                                ? ' Cancel Edit '
                                : ' Edit Prescription ';
                    }


                    if (open) {

                        setTimeout(function () {

                            const firstInput =
                                panel.querySelector(
                                    'input:not([type="hidden"]), select, textarea'
                                );

                            if (firstInput) {
                                firstInput.focus();
                            }

                        }, 180);
                    }
                }
            );
        });



    /*
    |--------------------------------------------------------------------------
    | Cancel Edit Prescription
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-prescription-edit-cancel]'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const targetId =
                        button.dataset.target;

                    const panel =
                        document.getElementById(
                            targetId
                        );


                    if (!panel) {
                        return;
                    }


                    panel.classList.remove(
                        'is-open'
                    );


                    const toggle =
                        document.querySelector(
                            '[data-prescription-edit-toggle]' +
                            '[data-target="' +
                            targetId +
                            '"]'
                        );


                    if (toggle) {

                        toggle.setAttribute(
                            'aria-expanded',
                            'false'
                        );


                        const icon =
                            toggle.querySelector('i');


                        if (icon) {

                            icon.className =
                                'bi bi-pencil-square';
                        }


                        const textNodes =
                            Array.from(
                                toggle.childNodes
                            ).filter(
                                function (node) {

                                    return (
                                        node.nodeType ===
                                        Node.TEXT_NODE
                                    );
                                }
                            );


                        if (textNodes.length) {

                            textNodes[
                                textNodes.length - 1
                            ].textContent =
                                ' Edit Prescription ';
                        }
                    }
                }
            );
        });



    /*
    |--------------------------------------------------------------------------
    | Delete Prescription Confirmation
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-prescription-delete]'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function (event) {

                    const medicine =
                        button.dataset.medicine ||
                        'this prescription';


                    const confirmed =
                        window.confirm(
                            'Are you sure you want to delete ' +
                            medicine +
                            '? This action cannot be undone.'
                        );


                    if (!confirmed) {

                        event.preventDefault();
                    }
                }
            );
        });

});