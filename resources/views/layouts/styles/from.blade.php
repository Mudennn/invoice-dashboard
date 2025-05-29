<style>
    /* ------------------------------------------------------------ */

    /* BASIC FORM */

    /* .form-container .form-container-content h1 {
        font-size: var(--eighteen) !important;
        font-weight: 700 !important;
        color: var(--text-color) !important;
        font-family: "Domine", serif !important;
        margin-bottom: 8px !important;
    }

    .form-container-content {
        padding: 24px;
    } */

    .form-header-container {
        padding: 40px 32px;
    }

    .form-input-container {
        padding: 32px;
    }

    .input-form {
        display: flex;
        flex-direction: column;
        margin: 16px 0;
        flex: 1;
    }

    .input-form textarea {
        height: 150px !important;
        padding: 8px 12px !important;
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        background-color: var(--bg-screen) !important;
        transition: all 0.3s !important;
    }

    .input-form textarea:focus {
        border: 1px solid var(--primary) !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .input-form textarea:active {
        border: 1px solid var(--primary) !important;
        outline: none !important;
    }

    .form-control {
        padding: 8px 12px !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 8px !important;
        background-color: var(--bg-screen) !important;
        width: 100% !important;
        transition: all 0.3s !important;

    }

    .form-control:focus {
        border: 1px solid var(--primary) !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .form-controll:disabled {
        background-color: #ddd !important;
        color: var(--text-color) !important;
    }

    .input-form label {
        margin-bottom: 4px !important;
        font-size: var(--fourteen) !important;
        color: var(--secondary) !important;
    }

    input::placeholder {
        font-size: 0.875rem !important;
    }

    .row-form {
        display: flex;
        align-items: center;
        justify-content: start;
        gap: 32px;
    }

    .row-form-container {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-button-container {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        padding: 32px;
        position: sticky;
        bottom: 0;
        background-color: white;
        z-index: 100;
        margin-top: 0;
        border-top: 1px solid var(--border);
    }

    /* PHONE MEDIA QUERY */
    @media only screen and (max-width: 767px) {
        .row-form {
            flex-direction: column;
        }

        .form-header-container {
            padding: 40px 16px;
        }

        .form-input-container {
            padding: 32px 16px;
        }

        .form-button-container {
            padding: 32px 16px;
        }
    }


    /* TABLET AND IPAD QUERY */
    @media (min-width: 768px) and (max-width: 1024px) {
        .form-header-container {
            padding: 40px 16px;
        }

        .form-input-container {
            padding: 32px 16px;
        }

        .form-button-container {
            padding: 32px 16px;
        }
    }
</style>
