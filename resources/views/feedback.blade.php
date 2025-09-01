<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - GDM</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .feedback-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .feedback-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2d3748;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #718096;
            font-size: 1.1rem;
            font-weight: 400;
        }

        .icon-header {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.error {
            border-color: #e53e3e;
            background: #fed7d7;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .rating-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .star {
            font-size: 2.5rem;
            color: #cbd5e0;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .star:hover,
        .star.active {
            color: #f6ad55;
            transform: scale(1.1);
        }

        .star.selected {
            color: #f6ad55;
        }

        .rating-text {
            text-align: center;
            margin-top: 10px;
            color: #4a5568;
            font-weight: 500;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .submit-btn .material-icons {
            margin-right: 8px;
            vertical-align: middle;
        }

        .success-message {
            background: #c6f6d5;
            color: #22543d;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-top: 20px;
            display: none;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.9rem;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .feedback-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .star {
                font-size: 2rem;
            }

            .form-control {
                padding: 12px 16px;
            }

            .submit-btn {
                padding: 14px 24px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .feedback-container {
                padding: 25px 15px;
            }

            .header h1 {
                font-size: 1.75rem;
            }

            .star {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="feedback-container">
        <div class="header">
            <div class="icon-header">
                <span class="material-icons">feedback</span>
            </div>
            <h1>We'd Love Your Feedback</h1>
            <p>Help us improve by sharing your thoughts and experience</p>
        </div>

        <form id="feedbackForm">
            <div class="form-group">
                <label for="name">
                    <span class="material-icons" style="font-size: 1rem; vertical-align: middle; margin-right: 5px;">person</span>
                    Full Name
                </label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
                <div class="error-message" id="name-error"></div>
            </div>

            <div class="form-group">
                <label for="email">
                    <span class="material-icons" style="font-size: 1rem; vertical-align: middle; margin-right: 5px;">email</span>
                    Email Address
                </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label>
                    <span class="material-icons" style="font-size: 1rem; vertical-align: middle; margin-right: 5px;">star</span>
                    Rating
                </label>
                <div class="rating-container">
                    <span class="star material-icons" data-rating="1">star</span>
                    <span class="star material-icons" data-rating="2">star</span>
                    <span class="star material-icons" data-rating="3">star</span>
                    <span class="star material-icons" data-rating="4">star</span>
                    <span class="star material-icons" data-rating="5">star</span>
                </div>
                <div class="rating-text" id="rating-text">Click on a star to rate</div>
                <input type="hidden" id="rating" name="rating" required>
                <div class="error-message" id="rating-error"></div>
            </div>

            <div class="form-group">
                <label for="message">
                    <span class="material-icons" style="font-size: 1rem; vertical-align: middle; margin-right: 5px;">message</span>
                    Your Feedback
                </label>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Tell us about your experience, suggestions, or any issues you encountered..." required></textarea>
                <div class="error-message" id="message-error"></div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="material-icons">send</span>
                Submit Feedback
            </button>
        </form>

        <div class="success-message" id="successMessage">
            <span class="material-icons" style="font-size: 2rem; color: #38a169; margin-bottom: 10px;">check_circle</span>
            <div id="successText"></div>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Submitting your feedback...</p>
        </div>

        <div class="footer">
            <p>Thank you for helping us improve! <a href="/">← Back to Home</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('feedbackForm');
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const successText = document.getElementById('successText');
            const loading = document.getElementById('loading');

            let selectedRating = 0;

            // Star rating functionality
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    selectedRating = rating;
                    ratingInput.value = rating;

                    // Update star display
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });

                    // Update rating text
                    const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                    ratingText.textContent = ratingLabels[rating];
                });

                // Hover effects
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    stars.forEach(s => s.classList.remove('active'));
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!selectedRating) {
                    showError('rating', 'Please select a rating');
                    return;
                }

                // Clear previous errors
                clearErrors();

                // Show loading
                submitBtn.disabled = true;
                loading.style.display = 'block';
                successMessage.style.display = 'none';

                // Get form data
                const formData = new FormData(form);

                // Send request
                fetch('/feedback', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        email: formData.get('email'),
                        rating: formData.get('rating'),
                        message: formData.get('message')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';

                    if (data.success) {
                        successText.textContent = data.message;
                        successMessage.style.display = 'block';
                        form.reset();
                        selectedRating = 0;
                        stars.forEach(s => s.classList.remove('selected'));
                        ratingText.textContent = 'Click on a star to rate';

                        // Reset form
                        setTimeout(() => {
                            successMessage.style.display = 'none';
                        }, 5000);
                    } else {
                        // Show validation errors
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                showError(field, data.errors[field][0]);
                            });
                        } else {
                            showError('general', data.message || 'Something went wrong. Please try again.');
                        }
                    }
                })
                .catch(error => {
                    loading.style.display = 'none';
                    showError('general', 'Network error. Please check your connection and try again.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                });
            });

            function showError(field, message) {
                if (field === 'general') {
                    // Show general error at the top
                    const generalError = document.createElement('div');
                    generalError.className = 'error-message';
                    generalError.style.display = 'block';
                    generalError.style.color = '#e53e3e';
                    generalError.style.background = '#fed7d7';
                    generalError.style.padding = '10px';
                    generalError.style.borderRadius = '8px';
                    generalError.style.marginBottom = '20px';
                    generalError.textContent = message;

                    form.insertBefore(generalError, form.firstChild);

                    setTimeout(() => {
                        if (generalError.parentNode) {
                            generalError.parentNode.removeChild(generalError);
                        }
                    }, 5000);
                } else {
                    const errorElement = document.getElementById(field + '-error');
                    if (errorElement) {
                        errorElement.textContent = message;
                        errorElement.style.display = 'block';
                        document.getElementById(field).classList.add('error');
                    }
                }
            }

            function clearErrors() {
                document.querySelectorAll('.error-message').forEach(error => {
                    error.style.display = 'none';
                    error.textContent = '';
                });

                document.querySelectorAll('.form-control').forEach(input => {
                    input.classList.remove('error');
                });
            }
        });
    </script>
</body>
</html>
