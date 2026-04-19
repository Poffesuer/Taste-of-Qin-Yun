/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Vanilla JS class to format and validate raw form inputs flawlessly in real-time during the checkout process.
 */
class CheckoutValidator {
    constructor() {
        this.form = document.querySelector('.checkout-container');
        if (!this.form) return;

        this.purchaseBtn = document.querySelector('.checkout-purchase-btn');
        this.fields = {
            contact: document.getElementById('contact'),
            first_name: document.getElementById('first_name'),
            last_name: document.getElementById('last_name'),
            address: document.getElementById('address'),
            cc_number: document.getElementById('cc_number'),
            cc_exp: document.getElementById('cc_exp'),
            cc_cvc: document.getElementById('cc_cvc'),
            cc_name: document.getElementById('cc_name'),
        };

        this.cardType = 'unknown';
        this.isFormValid = false;

        this.bindEvents();
        this.validateForm(); // initial check
    }

    /**
     * Binds input validation and formatting event listeners to each checkout field
     * Executes real-time masking on keystrokes and deep validation on blur
     */
    bindEvents() {
        Object.keys(this.fields).forEach(key => {
            const input = this.fields[key];
            if (!input) return;

            // Real-time masking & formatting
            input.addEventListener('input', (e) => this.handleInput(key, e));

            // Validation on blur and on change
            input.addEventListener('blur', () => {
                this.validateField(key);
                this.validateForm();
            });
        });

        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    /**
     * Masks and auto-formats user inputs keystroke-by-keystroke securely.
     * Prevents invalid characters from ever entering the input UI state.
     */
    handleInput(key, e) {
        const input = this.fields[key];
        let val = input.value;

        switch (key) {
            case 'first_name':
            case 'last_name':
                // Auto-capitalize first letter, letters only
                val = val.replace(/[^A-Za-z\s-]/g, '');
                if (val.length > 0) {
                    val = val.charAt(0).toUpperCase() + val.slice(1);
                }
                input.value = val;
                this.validateField(key);
                break;
            case 'cc_number':
                // Auto-format into groups of 4, numbers only
                let rawNum = val.replace(/\D/g, '').substring(0, 16);

                // Detect card type (simplified)
                if (/^4/.test(rawNum)) this.cardType = 'visa';
                else if (/^5[1-5]/.test(rawNum) || /^2[2-7]/.test(rawNum)) this.cardType = 'mastercard';
                else if (/^3[47]/.test(rawNum)) this.cardType = 'amex';
                else this.cardType = 'unknown';

                input.value = rawNum.replace(/(\d{4})(?=\d)/g, '$1 ');
                this.validateField(key);
                break;
            case 'cc_exp':
                // Format MM/YY
                let num = val.replace(/\D/g, '');
                if (num.length >= 2) {
                    let month = parseInt(num.substring(0, 2), 10);
                    if (month > 12) num = '12' + num.substring(2);
                    if (month === 0 && num.length > 1) num = '01' + num.substring(2);
                    input.value = num.substring(0, 2) + (num.length > 2 ? '/' + num.substring(2, 4) : '');
                } else {
                    input.value = num;
                }
                if (input.value.length === 5) this.validateField(key);
                break;
            case 'cc_cvc':
                // Numbers only, length depends on card
                const maxLen = this.cardType === 'amex' ? 4 : 3;
                input.value = val.replace(/\D/g, '').substring(0, maxLen);
                this.validateField(key);
                break;
            case 'cc_name':
                input.value = val.replace(/[^A-Za-z\s-]/g, '');
                this.validateField(key);
                break;
            case 'contact':
            case 'address':
                this.validateField(key);
                break;
        }

        this.validateForm();
    }

    /**
     * Structurally validates the exact business logic required for a field.
     * Evaluates expiration date safety and credit card lengths algorithmically.
     */
    validateField(key) {
        const input = this.fields[key];
        if (!input) return false;

        let isValid = true;
        let errorMessage = '';
        const val = input.value.trim();

        if (val === '') {
            this.setFieldState(key, false, 'This field is required');
            return false;
        }

        switch (key) {
            case 'contact':
                // Check if email or phone
                const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
                const isPhone = /^[\+\d\s\-\(\)]{10,15}$/.test(val);

                if (!isEmail && !isPhone) {
                    isValid = false;
                    errorMessage = 'Enter a valid email address or phone number';
                }
                break;

            case 'first_name':
            case 'last_name':
                if (val.length < 2) {
                    isValid = false;
                    errorMessage = 'Must be at least 2 characters';
                }
                break;

            case 'address':
                if (val.length < 5) {
                    isValid = false;
                    errorMessage = 'Please enter your full address';
                } else if (!/^[A-Za-z0-9\s,\.-]+$/.test(val)) {
                    isValid = false;
                    errorMessage = 'Address contains invalid characters';
                }
                break;

            case 'cc_number':
                const rawCc = val.replace(/\s/g, '');
                if (rawCc.length < 15 || rawCc.length > 16 || !this.luhnCheck(rawCc)) {
                    isValid = false;
                    errorMessage = 'Invalid credit card number';
                } else {
                    // Inject small visual badge logic if requested (optional string update)
                    // Currently relying on visual green validation text.
                }
                break;

            case 'cc_exp':
                if (val.length !== 5) {
                    isValid = false;
                    errorMessage = 'Enter date as MM/YY';
                } else {
                    const [mm, yy] = val.split('/');
                    const expYear = parseInt('20' + yy, 10);
                    const expMonth = parseInt(mm, 10);

                    const now = new Date();
                    const curMonth = now.getMonth() + 1;
                    const curYear = now.getFullYear();

                    if (expYear < curYear || (expYear === curYear && expMonth < curMonth)) {
                        isValid = false;
                        errorMessage = 'Card has expired';
                    }
                }
                break;

            case 'cc_cvc':
                const reqLen = this.cardType === 'amex' ? 4 : 3;
                if (val.length !== reqLen) {
                    isValid = false;
                    errorMessage = `CVC must be ${reqLen} digits`;
                }
                break;

            case 'cc_name':
                if (val.split(' ').filter(w => w.length > 0).length < 2) {
                    isValid = false;
                    errorMessage = 'Enter full name (First & Last)';
                }
                break;
        }

        this.setFieldState(key, isValid, errorMessage);
        return isValid;
    }

    /**
     * Decorator pattern updating CSS border states and toggling error messages visually.
     */
    setFieldState(key, isValid, errorMsg) {
        const input = this.fields[key];
        const errorSpan = document.getElementById(`error-${key}`);

        if (isValid) {
            input.classList.remove('invalid');
            input.classList.add('valid');
            if (errorSpan) {
                errorSpan.style.display = 'none';
                errorSpan.innerText = '';
            }
        } else {
            input.classList.remove('valid');
            input.classList.add('invalid');
            if (errorSpan) {
                errorSpan.style.display = 'block';
                errorSpan.innerText = errorMsg || 'Invalid value';
            }
        }
    }

    /**
     * Mathmatical cryptographic validation checking for real Credit Card generation patterns.
     * Rejects falsely generated structural sequences natively (Luhn Module 10 verification).
     */
    luhnCheck(val) {
        let sum = 0;
        let shouldDouble = false;
        // Loop from right to left
        for (let i = val.length - 1; i >= 0; i--) {
            let digit = parseInt(val.charAt(i));

            if (shouldDouble) {
                if ((digit *= 2) > 9) digit -= 9;
            }

            sum += digit;
            shouldDouble = !shouldDouble;
        }
        return (sum % 10) === 0;
    }

    validateForm() {
        this.isFormValid = true;
        Object.keys(this.fields).forEach(key => {
            const input = this.fields[key];
            if (input && !input.classList.contains('valid')) {
                this.isFormValid = false;
            }
        });

        if (this.isFormValid) {
            this.purchaseBtn.removeAttribute('disabled');
        } else {
            this.purchaseBtn.setAttribute('disabled', 'disabled');
        }
    }

    handleSubmit(e) {
        // Run full scan
        Object.keys(this.fields).forEach(key => this.validateField(key));
        this.validateForm();

        if (!this.isFormValid) {
            e.preventDefault();
            // Trigger shake
            Object.keys(this.fields).forEach(key => {
                const input = this.fields[key];
                if (input && input.classList.contains('invalid')) {
                    input.style.animation = 'none';
                    setTimeout(() => {
                        input.style.animation = 'shake 0.4s ease-in-out';
                    }, 10);
                }
            });
        } else {
            // Visual loading state
            this.purchaseBtn.classList.add('is-loading');
            this.purchaseBtn.innerText = 'Processing...';
            // Allow default submission to PHP
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new CheckoutValidator();
});
