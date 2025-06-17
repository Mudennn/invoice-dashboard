/**
 * Shared JavaScript functionality for invoice, debit note, credit note, and refund note forms
 */
document.addEventListener('DOMContentLoaded', function() {

    // Initialize Select2
    if ($.fn.select2) {
        $('.customer-select-input').select2({
            placeholder: "Select a customer",
            allowClear: true,
            width: '100%'
        });
    }
    
    // Handle shipping fields toggle
    const shippingToggle = document.getElementById('enable-shipping');
    if (shippingToggle) {
        shippingToggle.addEventListener('change', function() {
            const shippingFields = document.querySelectorAll('.shipping-field');
            shippingFields.forEach(field => {
                field.disabled = !this.checked;
                // Clear fields when disabled
                if (!this.checked) {
                    field.value = '';
                }
            });
        });
    }

    // Initialize row counter based on existing items
    let rowCount = 0;
    
    // Set the row count based on the form type
    if (document.querySelector('#invoice-items-body')) {
        if (document.querySelector('input[name="invoice_uuid"]')) {
            // For invoice form
            rowCount = document.querySelectorAll('#invoice-items-body .invoice-item-row').length;
        } else if (document.querySelector('input[name="debit_note_no"]')) {
            // For debit note form
            rowCount = document.querySelectorAll('#invoice-items-body .invoice-item-row').length;
        } else if (document.querySelector('input[name="credit_note_no"]')) {
            // For credit note form
            rowCount = document.querySelectorAll('#invoice-items-body .invoice-item-row').length;
        } else if (document.querySelector('input[name="refund_note_no"]')) {
            // For refund note form
            rowCount = document.querySelectorAll('#invoice-items-body .invoice-item-row').length;
        }
    }
    
    // Calculate totals on page load
    calculateTotals();
    
    // --------------------------------------------------------------
    // Form submission handler
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validate form before submission
            const errorContainer = document.getElementById('validation-errors');
            if (errorContainer) {
                errorContainer.innerHTML = '';
                errorContainer.style.display = 'none';
            }

            // Show loading state
            const submitButton = document.getElementById('btnSubmit');
            if (submitButton) {
                submitButton.disabled = true;
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = 'Processing...';
                
                // Re-enable the button after form submission
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }, 3000);
            }

            // Let the form submit normally to the server
            return true;
        });
    }
    
    // --------------------------------------------------------------
    // Add new item row
    const addItemBtn = document.getElementById('add-item-btn');
    if (addItemBtn) {
        addItemBtn.addEventListener('click', function() {
            const tbody = document.getElementById('invoice-items-body');
            const newRow = document.createElement('tr');
            newRow.className = 'invoice-item-row';
            
            newRow.innerHTML = `
                <td class="text-center">${rowCount + 1}</td>
                <td>
                    <input type="hidden" name="items[${rowCount}][id]" value="">
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control item-quantity" value="0" min="0">
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][description]" class="form-control" value="">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][unit_price]" class="form-control item-unit-price" value="0" min="0" step="0.01">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][amount]" class="form-control item-amount" value="0" readonly step="0.01">
                    <input type="hidden" name="items[${rowCount}][total]" class="item-total" value="0">
                </td>
                <td class="text-center">
                    <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                </td>
            `;
            
            tbody.appendChild(newRow);
            rowCount++;
            
            // Add event listeners to the new row
            addEventListenersToRow(newRow);
        });
    }
    
    // Add event listeners to existing rows
    document.querySelectorAll('.invoice-item-row').forEach(row => {
        addEventListenersToRow(row);
    });
    
    // Function to add event listeners to a row
    function addEventListenersToRow(row) {
        // Remove item
        const removeBtn = row.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                row.remove();
                updateRowNumbers();
                calculateTotals();
            });
        }
        
        // Calculate amount when quantity or unit price changes
        const quantityInput = row.querySelector('.item-quantity');
        const unitPriceInput = row.querySelector('.item-unit-price');
        
        if (quantityInput && unitPriceInput) {
            [quantityInput, unitPriceInput].forEach(input => {
                input.addEventListener('input', function() {
                    calculateRowAmount(row);
                    calculateTotals();
                });
            });
        }
    }
    
    // Update row numbers
    function updateRowNumbers() {
        document.querySelectorAll('#invoice-items-body tr').forEach((row, index) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
            
            // Update input names with new indices
            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }
    
    // Calculate amount for a row
    function calculateRowAmount(row) {
        const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
        const unitPrice = parseFloat(row.querySelector('.item-unit-price').value) || 0;
        const amount = quantity * unitPrice;
        
        const amountInput = row.querySelector('.item-amount');
        const totalInput = row.querySelector('.item-total');
        
        if (amountInput) amountInput.value = amount.toFixed(2);
        if (totalInput) totalInput.value = amount.toFixed(2);
    }
    
    // Calculate totals
    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-amount').forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });
        
        const subtotalElement = document.getElementById('subtotal');
        const totalElement = document.getElementById('total');
        
        if (subtotalElement) subtotalElement.textContent = subtotal.toFixed(2);
        if (totalElement) totalElement.textContent = subtotal.toFixed(2);
    }

    // --------------------------------------------------------------
    // Invoice Selection Modal - Only for debit/credit/refund notes
    const selectInvoiceBtn = document.getElementById('select-invoice-btn');
    if (selectInvoiceBtn) {
        selectInvoiceBtn.addEventListener('click', function() {
            // Get the route from data attribute or fallback to a default
            const indexRoute = this.getAttribute('data-index-route') || '/invoices?format=json';
            
            // Fetch available invoices
            fetch(indexRoute)
                .then(response => response.json())
                .then(data => {
                    populateInvoiceSelectionTable(data);
                    const modal = new bootstrap.Modal(document.getElementById('invoiceSelectionModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching invoices:', error);
                    alert('Failed to load invoices. Please try again.');
                });
        });
    }
    
    // Global variables for pagination
    let allInvoices = [];
    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredInvoices = [];
    
    // Populate invoice selection table with pagination and search
    function populateInvoiceSelectionTable(invoices) {
        const tableBody = document.querySelector('#invoice-selection-table tbody');
        const searchInput = document.getElementById('invoice-search');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const showingEntriesSpan = document.getElementById('showing-entries');
        
        if (!tableBody) return;
        
        // Store all invoices globally
        allInvoices = invoices || [];
        filteredInvoices = [...allInvoices];
        currentPage = 1;
        
        // Function to render the current page
        function renderCurrentPage() {
            tableBody.innerHTML = '';
            
            if (filteredInvoices.length > 0) {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, filteredInvoices.length);
                const currentPageData = filteredInvoices.slice(startIndex, endIndex);
                
                currentPageData.forEach(invoice => {
                    const row = document.createElement('tr');
                    
                    // Format date if it exists
                    const invoiceDate = invoice.invoice_date ? new Date(invoice.invoice_date).toLocaleDateString() : 'N/A';
                    
                    row.innerHTML = `
                        <td>${invoice.invoice_no || 'N/A'}</td>
                        <td>${invoiceDate}</td>
                        <td>${invoice.customer || 'N/A'}</td>
                        <td>RM${parseFloat(invoice.subtotal || 0).toFixed(2)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-primary select-invoice-btn" 
                                data-invoice-no="${invoice.invoice_no}">
                                Select
                            </button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                });
                
                // Update showing entries text
                showingEntriesSpan.textContent = `Showing ${startIndex + 1} to ${endIndex} of ${filteredInvoices.length} entries`;
                
                // Update pagination buttons
                prevPageBtn.classList.toggle('disabled', currentPage === 1);
                nextPageBtn.classList.toggle('disabled', endIndex >= filteredInvoices.length);
                
                // Add event listeners to select buttons
                document.querySelectorAll('.select-invoice-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const invoiceNo = this.getAttribute('data-invoice-no');
                        const detailsRoute = document.getElementById('select-invoice-btn').getAttribute('data-details-route');
                        
                        if (detailsRoute) {
                            loadInvoiceDetails(invoiceNo, detailsRoute);
                            
                            // Set the invoice number in the form
                            document.querySelector('input[name="invoice_no"]').value = invoiceNo;
                            
                            // Close the modal
                            bootstrap.Modal.getInstance(document.getElementById('invoiceSelectionModal')).hide();
                        } else {
                            console.error('No details route provided');
                        }
                    });
                });
            } else {
                // No invoices available
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" class="text-center">No invoices available</td>
                `;
                tableBody.appendChild(row);
                
                // Update showing entries text
                showingEntriesSpan.textContent = 'Showing 0 to 0 of 0 entries';
                
                // Disable pagination buttons
                prevPageBtn.classList.add('disabled');
                nextPageBtn.classList.add('disabled');
            }
        }
        
        // Initial render
        renderCurrentPage();
        
        // Set up search functionality
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                // Filter invoices based on search term
                filteredInvoices = allInvoices.filter(invoice => {
                    return (
                        (invoice.invoice_no && invoice.invoice_no.toLowerCase().includes(searchTerm)) ||
                        (invoice.customer && invoice.customer.toLowerCase().includes(searchTerm)) ||
                        (invoice.description && invoice.description.toLowerCase().includes(searchTerm))
                    );
                });
                
                // Reset to first page and render
                currentPage = 1;
                renderCurrentPage();
            });
        }
        
        // Set up pagination buttons
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderCurrentPage();
                }
            });
        }
        
        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const maxPage = Math.ceil(filteredInvoices.length / itemsPerPage);
                if (currentPage < maxPage) {
                    currentPage++;
                    renderCurrentPage();
                }
            });
        }
    }
    
    /**
     * Fetches and displays invoice details from the server
     * @param {string} invoice_no - The invoice number to fetch details for
     * @param {string} detailsRoute - The route to fetch invoice details
     */
    function loadInvoiceDetails(invoice_no, detailsRoute) {
        // Replace placeholder in route with actual invoice number
        const url = detailsRoute.replace(':invoice_no', invoice_no);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Received invoice data:', data); // Debug log

                // Set invoice UUID from invoice_uuid
                if (data.invoice_uuid) {
                    document.querySelector('input[name="invoice_uuid"]').value = data.invoice_uuid;
                }

                // Clear existing items
                const itemsTableBody = document.getElementById('invoice-items-body');
                itemsTableBody.innerHTML = '';
                rowCount = 0;

                // Add invoice items to the form
                if (data.items && data.items.length > 0) {
                    data.items.forEach((item, index) => {
                        const newRow = document.createElement('tr');
                        newRow.className = 'invoice-item-row';
                        
                        newRow.innerHTML = `
                            <td class="text-center">${index + 1}</td>
                            <td>
                                <input type="hidden" name="items[${index}][id]" value="">
                                <input type="number" name="items[${index}][quantity]" class="form-control item-quantity" value="${item.quantity}" min="0">
                            </td>
                            <td>
                                <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}">
                            </td>
                            <td>
                                <input type="number" name="items[${index}][unit_price]" class="form-control item-unit-price" value="${item.unit_price}" min="0" step="0.01">
                            </td>
                            <td>
                                <input type="number" name="items[${index}][amount]" class="form-control item-amount" value="${item.amount}" readonly step="0.01">
                                <input type="hidden" name="items[${index}][total]" class="item-total" value="${item.total}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                            </td>
                        `;
                        
                        itemsTableBody.appendChild(newRow);
                        rowCount++;
                        
                        // Add event listeners to the new row
                        addEventListenersToRow(newRow);
                    });
                    
                    // Update customer information if available
                    if (data.customer) {
                        const customerSelect = document.querySelector('select[name="customer"]');
                        if (customerSelect) {
                            for (let i = 0; i < customerSelect.options.length; i++) {
                                if (customerSelect.options[i].value === data.customer) {
                                    customerSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                    }
                    
                    // Fill billing/shipping information if available
                    if (data.billing_address) document.querySelector('textarea[name="billing_address"]').value = data.billing_address;
                    if (data.shipping_address) document.querySelector('textarea[name="shipping_address"]').value = data.shipping_address;
                    if (data.billing_attention) document.querySelector('input[name="billing_attention"]').value = data.billing_attention;
                    if (data.shipping_attention) document.querySelector('input[name="shipping_attention"]').value = data.shipping_attention;
                    if (data.shipping_info) document.querySelector('input[name="shipping_info"]').value = data.shipping_info;
                    
                    // Calculate totals
                    calculateTotals();
                }
            })
            .catch(error => {
                console.error('Error loading invoice details:', error);
                alert('Failed to load invoice details. Please try again.');
            });
    }
    
    // Display validation errors
    function displayErrors(errors) {
        const errorContainer = document.getElementById('validation-errors');
        if (!errorContainer) return;
        
        let errorList = '<ul class="list-unstyled mb-0">';
        
        if (typeof errors === 'object' && errors !== null) {
            // Handle Laravel's validation error format
            Object.keys(errors).forEach(field => {
                if (Array.isArray(errors[field])) {
                    errors[field].forEach(message => {
                        errorList += `<li>${message}</li>`;
                    });
                } else if (typeof errors[field] === 'string') {
                    errorList += `<li>${errors[field]}</li>`;
                }
            });
        } else if (typeof errors === 'string') {
            errorList += `<li>${errors}</li>`;
        } else if (Array.isArray(errors)) {
            errors.forEach(message => {
                errorList += `<li>${message}</li>`;
            });
        }
        
        errorList += '</ul>';
        errorContainer.innerHTML = errorList;
        errorContainer.style.display = 'block';
        
        // Scroll to error messages
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}); 