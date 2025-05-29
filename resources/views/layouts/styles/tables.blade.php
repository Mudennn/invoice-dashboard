<style>
    .table-header {
        padding: 48px 0 24px 0 !important;
        background-color: transparent !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h1 {
        font-size: var(--thirty-two) !important;
        font-weight: 700 !important;
    }

    .card {
        background: white !important;
        box-shadow: 4px 4px 6px 0 rgba(0, 0, 0, 0.1);
    }

    /* DATATABLE */
    table,
    th,
    td {
        padding: .782rem 1.25rem !important;
        border-collapse: collapse;
        text-align: left !important;
        font-size: 14px;
    }

    table th {
        background-color: #f0f0f0 !important;
        color: var(--secondary) !important;
        padding-block: 1.161rem !important;
    }


    div.dt-container .top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px !important;
    }

    /* SEARCH BAR */
    div.dt-container div.dt-search {
        display: flex;
        align-items: center;
        justify-content: end;
        gap: 8px;
        width: 50%;
    }

    div.dt-container .dt-search input {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        margin-left: 8px !important;
        width: 50% !important;
    }

    div.dt-container .dt-search input:focus {
        border: 1px solid var(--primary) !important;
        box-shadow: none !important;
    }

    /* SELECT ENTRIES */
    div.dt-container select.dt-input {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        margin-right: 16px !important;
        margin-bottom: 16px !important;
        padding: 4px 12px !important;
    }

    div.dt-container .bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 32px !important;
    }

    .dt-column-order {
        display: none !important;
    }

    .dt-column-order:hover {
        display: block !important;
    }

    /* PAGINATION */
    div.dt-container .dt-paging .dt-paging-button.current,
    div.dt-container .dt-paging .dt-paging-button.current:hover {
        border-radius: 8px !important;
        border: 1px solid #ddd !important;
        color: var(--text-color) !important;
    }

    .page-link.active,
    .active>.page-link {
        background-color: var(--primary-button-color) !important;
        border: 1px solid var(--text-color) !important;
        color: var(--text-color) !important;
        transition: all 0.3s;
    }

    .page-link.active,
    .active>.page-link:hover {
        background-color: var(--secondary-button-color) !important;
        border: 1px solid var(--text-color) !important;
        color: var(--text-color) !important;
    }

    .page-link {
        color: var(--text-color) !important;
    }

    /* -------------------------------------------- */

   .table-footer{
    width: 350px !important;
   }
    /* MOBILE SCREEN */
    @media screen and (max-width: 767px) {
        .table-header {
            flex-direction: column;
            gap: 24px;
            align-items: flex-start;
        }

        .table-header h1 {
            font-size: var(--twenty-four) !important;
            font-weight: 700 !important;
        }

        .table-header .primary-button {
            width: 100% !important;
        }

        div.dt-container div.dt-search {
            width: 100%;
        }

        div.dt-container .top,
        div.dt-container .bottom {
            flex-direction: column;
            gap: 24px;
        }

        .table-footer{
            width: 100% !important;
        }
    }

    /* TABLET AND IPAD QUERY */
    @media (min-width: 768px) and (max-width: 1024px) {}
</style>
