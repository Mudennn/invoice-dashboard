/**
 * Shared JavaScript functionality for invoice, debit note, credit note, and refund note forms
 */
document.addEventListener('DOMContentLoaded', function() {

    // Function to initialize Select2 for tax dropdowns
    function initializeTaxSelect2(element) {
        if ($.fn.select2) {
            $(element).select2({
                placeholder: "Select tax type",
                allowClear: true,
                width: '100%',
                templateSelection: function(data) {
                    if (!data.id) return data.text;
                    
                    // Get the tax code from the data attributes or from the global object
                    let taxCode = $(data.element).data('tax-code');
                    if (!taxCode && window.taxCodes && data.id) {
                        taxCode = window.taxCodes[data.id];
                    }
                    
                    // Return just the tax code for the selected item (without tax type)
                    return taxCode || data.text;
                }
            });
            
            // Add change event handlers
            $(element).on('select2:select select2:unselect select2:clear', function() {
                const row = $(this).closest('.invoice-item-row')[0];
                if (row) {
                    // Update tax code hidden field
                    const selectedOption = $(this).find('option:selected');
                    const taxCode = selectedOption.data('tax-code') || '';
                    const taxRate = selectedOption.data('tax-rate') || 0;
                    const taxCodeInput = $(row).find('.item-tax-code');
                    
                    if (taxCodeInput.length) {
                        taxCodeInput.val(taxCode);
                    } else {
                        // Create tax code field if it doesn't exist
                        const taxCodeInput = document.createElement('input');
                        taxCodeInput.type = 'hidden';
                        taxCodeInput.name = this.name.replace('tax_type', 'tax_code');
                        taxCodeInput.className = 'item-tax-code';
                        taxCodeInput.value = taxCode;
                        $(this).after(taxCodeInput);
                    }
                    
                    // Update tax rate and calculate tax amount
                    const amount = parseFloat($(row).find('.item-amount').val()) || 0;
                    const taxAmount = amount * (taxRate / 100);
                    
                    // Update tax amount hidden field
                    const taxAmountInput = $(row).find('.item-tax-amount');
                    if (taxAmountInput.length) {
                        taxAmountInput.val(taxAmount.toFixed(2));
                    }
                    
                    // Update tax rate hidden field
                    const taxRateInput = $(row).find('.item-tax-rate');
                    if (taxRateInput.length) {
                        taxRateInput.val(taxRate);
                    }
                    
                    calculateTotals();
                }
            });
        }
    }

    // Function to initialize Select2 for classification dropdowns
    function initializeClassificationSelect2(element) {
        if ($.fn.select2) {
            $(element).select2({
                placeholder: "Select classification",
                allowClear: true,
                width: '100%',
                templateSelection: function(data) {
                    if (!data.id) return data.text;
                    
                    // Get the classification code from the data attributes
                    let classificationCode = data.id;
                    
                    // Return just the classification code for the selected item
                    return classificationCode || data.text;
                }
            });
        }
    }

    // Initialize Select2
    if ($.fn.select2) {
        $('.customer-select-input').select2({
            placeholder: "Select a customer",
            allowClear: true,
            width: '100%'
        });
        
        // Initialize Select2 for all existing tax dropdowns
        $('.item-tax').each(function() {
            const taxSelect = $(this);
            const savedTaxType = taxSelect.val();
            
            // Initialize Select2
            initializeTaxSelect2(this);
            
            // If there's a saved tax type, make sure it's selected after initialization
            if (savedTaxType) {
                console.log("Found saved tax type:", savedTaxType);
                
                // Use setTimeout to ensure Select2 is fully initialized
                setTimeout(() => {
                    taxSelect.val(savedTaxType).trigger('change');
                }, 200);
            }
        });
        
        // Initialize Select2 for all existing classification dropdowns
        $('.item-classification').each(function() {
            const classificationSelect = $(this);
            const savedClassification = classificationSelect.val();
            
            // Initialize Select2
            initializeClassificationSelect2(this);
            
            // If there's a saved classification, make sure it's selected after initialization
            if (savedClassification) {
                console.log("Found saved classification:", savedClassification);
                
                // Use setTimeout to ensure Select2 is fully initialized
                setTimeout(() => {
                    classificationSelect.val(savedClassification).trigger('change');
                }, 200);
            }
        });
        
        // Ensure tax data is loaded
        if (!window.taxRates || !window.taxCodes) {
            fetchTaxData();
        }
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
        
        // Update row numbers on page load to ensure consistency
        updateRowNumbers();
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
            const currentRowCount = tbody.querySelectorAll('tr').length;
            const newRow = document.createElement('tr');
            newRow.className = 'invoice-item-row';
            
            // If tax data isn't loaded yet, fetch it
            if (!window.taxOptions) {
                fetchTaxData();
            }
            
            newRow.innerHTML = `
                <td class="text-center">${currentRowCount + 1}</td>
                <td>
                    <input type="hidden" name="items[${currentRowCount}][id]" value="">
                    <input type="number" name="items[${currentRowCount}][quantity]" class="form-control item-quantity" value="0" min="0">
                </td>
                <td>
                    <input type="text" name="items[${currentRowCount}][description]" class="form-control" value="">
                </td>
                <td>
                    <input type="number" name="items[${currentRowCount}][unit_price]" class="form-control item-unit-price" value="0" min="0" step="0.01">
                </td>
                <td>
                    <input type="number" name="items[${currentRowCount}][amount]" class="form-control item-amount" value="0" readonly step="0.01">
                    <input type="hidden" name="items[${currentRowCount}][total]" class="item-total" value="0">
                </td>
                <td>
                    <select name="items[${currentRowCount}][classification_code]" class="form-control item-classification">
                        <option value=""> {{ 'Choose :' }}</option>
                        ${window.classificationOptions || ''}
                    </select>
                </td>
                <td>
                    <select name="items[${currentRowCount}][tax_type]" class="form-control item-tax">
                        <option value=""> {{ 'Choose :' }}</option>
                        ${window.taxOptions || ''}
                    </select>
                    <input type="hidden" name="items[${currentRowCount}][tax_code]" class="item-tax-code" value="">
                    <input type="hidden" name="items[${currentRowCount}][tax_rate]" class="item-tax-rate" value="0">
                    <input type="hidden" name="items[${currentRowCount}][tax_amount]" class="item-tax-amount" value="0">
                </td>
                <td class="text-center">
                    <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                </td>
            `;
            
            tbody.appendChild(newRow);
            rowCount = currentRowCount + 1;
            
            // Add event listeners to the new row
            addEventListenersToRow(newRow);
            
            // Initialize Select2 for the new tax dropdown
            if ($.fn.select2) {
                initializeTaxSelect2($(newRow).find('.item-tax'));
                initializeClassificationSelect2($(newRow).find('.item-classification'));
            }
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
        const taxSelect = row.querySelector('.item-tax');
        
        if (quantityInput && unitPriceInput) {
            [quantityInput, unitPriceInput].forEach(input => {
                input.addEventListener('input', function() {
                    // Calculate base amount
                    const quantity = parseFloat(quantityInput.value) || 0;
                    const unitPrice = parseFloat(unitPriceInput.value) || 0;
                    const amount = quantity * unitPrice;
                    
                    // Update amount field
                    const amountInput = row.querySelector('.item-amount');
                    if (amountInput) {
                        amountInput.value = amount.toFixed(2);
                    }
                    
                    // Update excluding_tax field
                    const excludingTaxInput = row.querySelector('input[name$="[excluding_tax]"]');
                    if (excludingTaxInput) {
                        excludingTaxInput.value = amount.toFixed(2);
                    }
                    
                    // Calculate tax amount based on selected tax type
                    let taxRate = 0;
                    if (taxSelect) {
                        const selectedOption = $(taxSelect).find('option:selected');
                        if (selectedOption.length) {
                            taxRate = parseFloat(selectedOption.data('tax-rate')) || 0;
                        } else if (window.taxRates && taxSelect.value) {
                            taxRate = parseFloat(window.taxRates[taxSelect.value]) || 0;
                        }
                    }
                    
                    // Update tax amount
                    const taxAmount = amount * (taxRate / 100);
                    const taxAmountInput = row.querySelector('input[name$="[tax_amount]"]');
                    if (taxAmountInput) {
                        taxAmountInput.value = taxAmount.toFixed(2);
                    }
                    
                    // Update total
                    const total = amount + taxAmount;
                    const totalInput = row.querySelector('.item-total');
                    if (totalInput) {
                        totalInput.value = total.toFixed(2);
                    }
                    
                    calculateTotals();
                });
            });
        }
        
        // Calculate tax when tax type changes
        if (taxSelect) {
            // For regular change event
            taxSelect.addEventListener('change', function() {
                // This is now handled by the Select2 event handlers
                calculateTotals();
            });
            
            // For Select2 change event
            if ($.fn.select2) {
                $(taxSelect).on('select2:select', function() {
                    // This is now handled by the Select2 event handlers in initializeTaxSelect2
                    calculateTotals();
                });
            }
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
            
            // Update select names with new indices
            const selects = row.querySelectorAll('select');
            selects.forEach(select => {
                const name = select.getAttribute('name');
                if (name) {
                    const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                    select.setAttribute('name', newName);
                }
            });
        });
        
        // Update global row counter to match the current number of rows
        rowCount = document.querySelectorAll('#invoice-items-body tr').length;
    }
    
    // Calculate totals
    function calculateTotals() {
        let subtotal = 0;
        let excludingTaxTotal = 0;
        let taxAmountTotal = 0;
        
        document.querySelectorAll('.invoice-item-row').forEach(row => {
            // Get amount and tax amount from inputs
            const amount = parseFloat(row.querySelector('.item-amount').value) || 0;
            const taxAmountInput = row.querySelector('.item-tax-amount');
            let taxAmount = 0;
            
            // If we have a tax amount input, use its value
            if (taxAmountInput) {
                taxAmount = parseFloat(taxAmountInput.value) || 0;
            } else {
                // Otherwise calculate from tax rate
                const taxSelect = row.querySelector('.item-tax');
                let taxRate = 0;
                
                if (taxSelect) {
                    // For regular select
                    const selectedTaxType = taxSelect.value;
                    
                    // Find the tax rate from the global tax rates object
                    if (window.taxRates && selectedTaxType && window.taxRates[selectedTaxType]) {
                        taxRate = parseFloat(window.taxRates[selectedTaxType]) || 0;
                    }
                }
                
                // Calculate tax amount
                taxAmount = amount * (taxRate / 100);
            }
            
            const total = amount + taxAmount;
            
            excludingTaxTotal += amount;
            taxAmountTotal += taxAmount;
            subtotal += total;
            
            // Update hidden fields with the latest calculations
            const totalInput = row.querySelector('.item-total');
            if (totalInput) totalInput.value = total.toFixed(2);
        });
        
        const excludingTaxElement = document.getElementById('excluding_tax');
        const taxAmountElement = document.getElementById('tax-amount');
        const subtotalElement = document.getElementById('subtotal');
        const totalElement = document.getElementById('total');
        
        if (excludingTaxElement) excludingTaxElement.textContent = excludingTaxTotal.toFixed(2);
        if (taxAmountElement) taxAmountElement.textContent = taxAmountTotal.toFixed(2);
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
    function populateInvoiceSelectionTable(data) {
        const tableBody = document.querySelector('#invoice-selection-table tbody');
        const searchInput = document.getElementById('invoice-search');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const showingEntriesSpan = document.getElementById('showing-entries');
        
        if (!tableBody) return;
        
        // Store all invoices globally
        allInvoices = data.invoices || data || [];
        filteredInvoices = [...allInvoices];
        currentPage = 1;
        
        // Initialize tax data if available
        if (data.taxesData) {
            initializeTaxData(data.taxesData);
        }
        
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

                // Initialize tax data if available
                if (data.taxesData) {
                    initializeTaxData(data.taxesData);
                } else {
                    // If tax data is not included, fetch it
                    fetchTaxData();
                }
                
                // Initialize classification data if available
                if (data.classificationsData) {
                    initializeClassificationData(data.classificationsData);
                }

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
                                <input type="hidden" name="items[${index}][excluding_tax]" class="item-excluding_tax" value="${item['excluding_tax'] || item.amount}">
                            </td>
                            <td>
                                <select name="items[${index}][classification_code]" class="form-control item-classification">
                                    <option value=""> {{ 'Choose :' }}</option>
                                    ${window.classificationOptions || ''}
                                </select>
                            </td>
                            <td>
                                <select name="items[${index}][tax_type]" class="form-control item-tax">
                                    <option value=""> {{ 'Choose :' }}</option>
                                    ${window.taxOptions || ''}
                                </select>
                                <input type="hidden" name="items[${index}][tax_code]" class="item-tax-code" value="${item.tax_code || ''}">
                                <input type="hidden" name="items[${index}][tax_rate]" class="item-tax-rate" value="${item.tax_rate || 0}">
                                <input type="hidden" name="items[${index}][tax_amount]" class="item-tax-amount" value="${item.tax_amount || 0}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                            </td>
                        `;
                        
                        itemsTableBody.appendChild(newRow);
                        rowCount++;
                        
                        // Add event listeners to the new row
                        addEventListenersToRow(newRow);
                        
                        // Initialize Select2 for the tax dropdown
                        if ($.fn.select2) {
                            const taxSelect = $(newRow).find('.item-tax');
                            const savedTaxType = item.tax_type;
                            
                            // Initialize Select2
                            initializeTaxSelect2(taxSelect);
                            
                            // If there's a saved tax type, make sure it's selected after initialization
                            if (savedTaxType) {
                                console.log("Loading saved tax type:", savedTaxType);
                                
                                // Use setTimeout to ensure Select2 is fully initialized
                                setTimeout(() => {
                                    taxSelect.val(savedTaxType).trigger('change');
                                }, 200);
                            }
                            
                            // Initialize Select2 for the classification dropdown
                            const classificationSelect = $(newRow).find('.item-classification');
                            const savedClassification = item.classification_code;
                            
                            // Initialize Select2
                            initializeClassificationSelect2(classificationSelect);
                            
                            // If there's a saved classification, make sure it's selected after initialization
                            if (savedClassification) {
                                console.log("Loading saved classification:", savedClassification);
                                
                                // Use setTimeout to ensure Select2 is fully initialized
                                setTimeout(() => {
                                    classificationSelect.val(savedClassification).trigger('change');
                                }, 200);
                            }
                        }
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
                    
                    // Update row numbers to ensure consistency
                    updateRowNumbers();
                    
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

    // Function to initialize tax data from the server
    function initializeTaxData(taxData) {
        if (!taxData) return;
        
        // Create global tax rates object
        window.taxRates = {};
        window.taxCodes = {};
        window.taxOptions = '';
        
        // Process tax data
        taxData.forEach(tax => {
            window.taxRates[tax.tax_type] = tax.tax_rate;
            window.taxCodes[tax.tax_type] = tax.tax_code;
            
            window.taxOptions += `
                <option value="${tax.tax_type}" data-tax-code="${tax.tax_code}" data-tax-rate="${tax.tax_rate}">
                    ${tax.tax_code} - ${tax.tax_type} (${tax.tax_rate}%)
                </option>
            `;
        });
    }
    
    // Function to initialize classification data from the server
    function initializeClassificationData(classificationData) {
        if (!classificationData) return;
        
        window.classificationOptions = '';
        
        // Process classification data
        classificationData.forEach(classification => {
            window.classificationOptions += `
                <option value="${classification.classification_code}">
                    ${classification.classification_code} - ${classification.description}
                </option>
            `;
        });
    }

    // Fetch tax data from the server
    function fetchTaxData() {
        // Only fetch if tax data is not already loaded
        if (!window.taxRates || !window.taxCodes) {
            fetch('/invoices?format=json')
                .then(response => response.json())
                .then(data => {
                    if (data.taxesData) {
                        initializeTaxData(data.taxesData);
                        
                        // Re-initialize any existing tax dropdowns
                        document.querySelectorAll('.item-tax').forEach(select => {
                            // Save the current value
                            const currentValue = select.value;
                            
                            // Update the options
                            if (window.taxOptions) {
                                // Clear existing options except the empty one
                                while (select.options.length > 1) {
                                    select.remove(1);
                                }
                                
                                // Insert new options
                                select.insertAdjacentHTML('beforeend', window.taxOptions);
                            }
                            
                            // Restore the selected value
                            if (currentValue) {
                                select.value = currentValue;
                            }
                            
                            // Re-initialize Select2 if it exists
                            if ($.fn.select2 && $(select).data('select2')) {
                                $(select).select2('destroy').select2({
                                    placeholder: "Select tax type",
                                    allowClear: true,
                                    width: '100%',
                                    templateSelection: function(data) {
                                        if (!data.id) return data.text;
                                        
                                        // Get the tax code from the data attributes or from the global object
                                        let taxCode = $(data.element).data('tax-code');
                                        if (!taxCode && window.taxCodes && data.id) {
                                            taxCode = window.taxCodes[data.id];
                                        }
                                        
                                        // Return just the tax code for the selected item (without tax type)
                                        return taxCode || data.text;
                                    }
                                });
                            }
                        });
                    }
                    
                    if (data.classificationsData) {
                        initializeClassificationData(data.classificationsData);
                        
                        // Re-initialize any existing classification dropdowns
                        document.querySelectorAll('.item-classification').forEach(select => {
                            // Save the current value
                            const currentValue = select.value;
                            
                            // Update the options
                            if (window.classificationOptions) {
                                // Clear existing options except the empty one
                                while (select.options.length > 1) {
                                    select.remove(1);
                                }
                                
                                // Insert new options
                                select.insertAdjacentHTML('beforeend', window.classificationOptions);
                            }
                            
                            // Restore the selected value
                            if (currentValue) {
                                select.value = currentValue;
                            }
                            
                            // Re-initialize Select2 if it exists
                            if ($.fn.select2 && $(select).data('select2')) {
                                $(select).select2('destroy').select2({
                                    placeholder: "Select classification",
                                    allowClear: true,
                                    width: '100%',
                                    templateSelection: function(data) {
                                        if (!data.id) return data.text;
                                        
                                        // Return just the classification code for the selected item
                                        return data.id || data.text;
                                    }
                                });
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    }
    
    // Fetch tax data on page load
    fetchTaxData();
}); 