<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", serif;
    }

    html,
    body {
        scroll-behavior: smooth;
        height: 100%;
    }

    body {
        background-color: var(--background) !important;
        color: black;
    }

    /* Variables */
    :root {
        --background: #f2f5ff;
        --foreground: white;
        --primary: #092276;
        --secondary: #1c1c1c;
        --button-gradient-start: #2F68FF;
        --button-gradient-end: #16327A;

        --tertiary: #1be3c2;
        --tertiary-foreground: #1be3c233;

        --quaternary: #efb54b;
        --quaternary-foreground: rgb(239, 181, 75, 0.2);

        --muted: #acacac;

        --destructive: #e7000c;

        --border: #E5E5E5;
        /*
        --text-color: #165235;
        --sub-text-color: #898989;
        --primary-button-color: #45CE7D;
        --secondary-button-color: #E5FC0B;
        --main-bg-color: #FEF6E7;
        --red-color: #C83000;
        --yellow-color: #FBBC05;
        --third-color: #E4D5C7; */

        --thirty-two: 2rem;
        --twenty-four: 1.5rem;
        --twenty-one: 1.313rem;
        --eighteen: 1.125rem;
        --sixteen: 1rem;
        --fourteen: 0.875rem;
        --twelve: 0.75rem;
        --eleven: 0.688rem;
    }

    h1 {
        font-size: 4rem !important;
        font-weight: 400 !important;
        color: var(--primary) !important;
        margin-bottom: 0 !important;
    }

    h2 {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: var(--primary) !important;
        margin-bottom: 0 !important;
    }

    h3 {
        font-size: var(--eighteen) !important;
        font-weight: 600 !important;
        color: var(--secondary) !important;
        margin-bottom: 0 !important;
    }

    h4 {
        font-size: 1rem !important;
        font-weight: 300 !important;
        margin-bottom: 0 !important;
        color: var(--primary) !important;
    }

    h6 {
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        margin-bottom: 0 !important;
        color: var(--primary) !important;
    }


    p {
        font-size: 0.875rem !important;
        color: var(--secondary) !important;
        margin-bottom: 0px !important;
        line-height: 1.5 !important;
        font-weight: 400 !important;
    }

    hr {
        border-top: 1px var(--border) solid !important;
        color: var(--border) !important;
        margin: 0 !important;
        opacity: 1 !important;
    }

    a {
        font-size: 0.875rem !important;
        text-decoration: none !important;
        margin-bottom: 0 !important;
        color: var(--primary) !important;
        transition: all 0.3s !important;

        &:hover {
            color: var(--secondary) !important;
        }
    }

    .sub-text {
        color: var(--muted) !important;
    }

    /* Main layout structure */
    .wrapper {
        display: flex;
        height: 100vh;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .main-content {
        flex: 1;
        background-color: white;
        margin: 16px;
        border-radius: 16px;
        overflow-y: auto;
        position: relative;
    }


    /* BUTTONS */
    .primary-button {
        background: linear-gradient(to top, var(--button-gradient-start), var(--button-gradient-end));
        padding: 2px 32px !important;
        border: none !important;
        border-radius: 4px !important;
        font-weight: 400 !important;
        font-size: var(--sixteen) !important;
        transition: all 0.3s !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        width: fit-content !important;

        &:hover {
            color: white !important;
        }
    }

    .back-button {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primary) !important;
        font-size: var(--fourteen) !important;
    }

    .delete-button {
        background-color: var(--destructive) !important;
        padding: 2px 32px !important;
        border-radius: 4px !important;
        border: none !important;
        font-weight: 400 !important;
        font-size: var(--sixteen) !important;
        transition: all 0.3s !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        width: fit-content !important;

        &:hover {
            color: white !important;
            background: #e43942 !important;
        }
    }

    .delete-icon-button {
        background-color: var(--destructive) !important;
        padding: 4px !important;
        border-radius: 50px !important;
        border: none !important;
        font-weight: 400 !important;
        color: white !important;
        font-size: var(--sixteen) !important;
    }

    .outline-button {
        background-color: white !important;
        color: var(--primary) !important;
        border: 1px solid var(--primary) !important;
        padding: 2px 32px !important;
        border-radius: 4px !important;
    }

    .btn-outline-primary {
        --bs-btn-border-color: var(--primary) !important;
    }

    .btn-check:checked+.btn,
    :not(.btn-check)+.btn:active,
    .btn:first-child:active,
    .btn.active,
    .btn.show {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }

    /* -------------------------------------------------------------- */
    /* SWEETALERT */

    .swal2-popup.swal2-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
        border-radius: 8px !important;
        border: 1px solid #c3e6cb !important;
    }

    .swal2-popup.swal2-toast.swal2-icon-error {
        background-color: #f27474 !important;
        border-radius: 8px !important;
        border: 1px solid #f5c6cb !important;
    }

    .swal2-popup.swal2-toast.swal2-icon-info {
        background-color: #f8bb86 !important;
        border-radius: 8px !important;
        border: 1px solid #ffeeba !important;
    }

    .swal2-popup.swal2-toast .swal2-title {
        color: white !important;
        font-size: 16px !important;
        font-weight: 500 !important;
        margin: 11px 8px 0 8px !important;
        padding: 0 !important;
    }

    .swal2-popup.swal2-toast .swal2-close {
        color: white !important;
    }

    .swal2-popup.swal2-toast .swal2-html-container {
        color: white !important;
    }

    /* Add these styles for white icons */
    .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
        border-color: white !important;
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-success [class^='swal2-success-line'] {
        background-color: white !important;
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
        background-color: white !important;
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error {
        border-color: white !important;
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-info {
        border-color: white !important;
        color: white !important;
    }

    /* -------------------------------------------------------------- */

    /* SELECT2 */
    .select2-container--default .select2-selection--single {
        padding: 6px !important;
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        /* background-color: var(--primary) !important; */
        width: 100% !important;
        font-size: 0.875rem !important;
        height: 42px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: var(--primary) !important;
    }

    /* Custom styles for select2 dropdown options */
    /* Specific styling for classification dropdown */
    /* #select2-items0classification_code-7p-results .select2-results__option,
    .item-classification+.select2-container--default .select2-results__option {
        font-size: 12px !important;
    }

    
    #select2-items0tax_type-t37q-results .select2-results__option,
    .item-tax+.select2-container--default .select2-results__option {
        font-size: 12px !important;
    } */

    /* Target all item classification and tax select2 results with wildcard */
    [id^="select2-items"][id*="classification_code"][id$="-results"] .select2-results__option,
    [id^="select2-items"][id*="tax_type"][id$="-results"] .select2-results__option {
        font-size: 12px !important;
        scrollbar-width: none;
    }

    /* -------------------------------------------------------------- */

    /* Mobile styles */
    @media only screen and (max-width: 767px) {
        .main-content {
            margin: 0;
        }
    }

    /* Tablet styles */
    @media (min-width: 768px) and (max-width: 1024px) {
        .main-content {
            margin: 0;
        }
    }
</style>
