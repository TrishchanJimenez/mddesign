<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Inquiry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E5E4E2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #1E1E1E;
            padding: 10px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
            font-weight: bold;
        }

        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }

        .navbar-nav {
            flex-grow: 1;
            justify-content: center;
        }

        .navbar-nav .nav-link {
            color: white !important;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 10px;
        }

        .navbar-nav.ms-auto {
            margin-right: 0 !important;
            align-items: center;
        }

        /* Search Bar Styles */
        .search-container {
            position: relative;
            margin-left: 15px;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            color: white;
        }

        .nav-icons i {
            cursor: pointer;
            margin-left: 15px;
        }

        /* Search Popup Styles */
        .search-popup {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
            width: 200px;
            z-index: 1000;
        }

        .search-popup input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-popup.active {
            display: block;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }
        
        .commissioned-hero {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .commissioned-hero h1 {
            font-size: 32px;
            color: #333;
            text-transform: uppercase;
        }
        
        .commissioned-hero p {
            font-style: italic;
            color: #666;
            margin-top: 5px;
        }
        
        /* Hide the design customization section */
        .design-customization {
            display: none;
        }
        
        /* Canvas for image processing */
        #processing-canvas {
            display: none;
        }
        
        /* New styles for transparency guidance */
        .transparent-tip {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
        }

        .background-removal-controls {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .transparency-preview {
            border: 1px dashed #999;
            padding: 5px;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .checkerboard-bg {
            background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), 
                              linear-gradient(-45deg, #ccc 25%, transparent 25%), 
                              linear-gradient(45deg, transparent 75%, #ccc 75%), 
                              linear-gradient(-45deg, transparent 75%, #ccc 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
        
        /* Media queries for responsive design */
        @media (max-width: 768px) {
            .design-section {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Hidden canvas for image processing -->
    <canvas id="processing-canvas"></canvas>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="Homepage.php">
                <img src="/api/placeholder/40/40" class="rounded-circle">
                Metro District Designs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Homepage.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Products.php">PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="Commissioned.php">INQUIRY</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Signup.php">SIGN-UP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php">LOGIN</a>
                    </li>
                    <li class="nav-item nav-icons">
                        <i class="bi bi-cart cart-icon" id="cartIcon"></i>
                        <div class="search-container">
                            <i class="bi bi-search search-icon" id="searchToggle"></i>
                            <div class="search-popup" id="searchPopup">
                                <input type="text" placeholder="Search designs..." id="searchInput">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
    <div class="commissioned-hero">
        <h1>Design Inquiry</h1>
        <p>Have a custom design in mind? Let us know what you're looking for!</p>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Send Us Your Design Inquiry</h5>
                    <form id="inquiryForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone (optional)</label>
                            <input type="tel" class="form-control" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="designType" class="form-label">Design Type</label>
                            <select class="form-select" id="designType" required>
                                <option value="" selected disabled>Select a design type</option>
                                <option value="tshirt">T-Shirt Design</option>
                                <option value="poster">Poster Design</option>
                                <option value="logo">Logo Design</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Design Description</label>
                            <textarea class="form-control" id="description" rows="5" placeholder="Please provide as much detail as possible about your design needs..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Reference Images (optional)</label>
                            <input type="file" class="form-control" id="fileUpload" multiple>
                            <div class="form-text">Upload any reference images that might help us understand your vision.</div>
                        </div>
                        <div class="mb-3">
                            <label for="budget" class="form-label">Budget Range (PHP)</label>
                            <select class="form-select" id="budget">
                                <option value="" selected disabled>Select your budget range</option>
                                <option value="under100">Under ₱100</option>
                                <option value="100-200">₱100 - ₱200</option>
                                <option value="200-500">₱200 - ₱500</option>
                                <option value="over500">Over ₱500</option>
                                <option value="flexible">Flexible/Not Sure</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="timeline" class="form-label">Timeline</label>
                            <select class="form-select" id="timeline">
                                <option value="" selected disabled>When do you need this by?</option>
                                <option value="urgent">ASAP (1-3 days)</option>
                                <option value="standard">Standard (1-2 weeks)</option>
                                <option value="relaxed">No Rush (2+ weeks)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Submit Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Our Design Process</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-dark rounded-circle p-2">1</span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Initial Consultation</h6>
                                    <p class="mb-0 text-muted">We'll discuss your needs and provide a quote.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-dark rounded-circle p-2">2</span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Concept Development</h6>
                                    <p class="mb-0 text-muted">We'll create initial design concepts based on your requirements.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-dark rounded-circle p-2">3</span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Revisions</h6>
                                    <p class="mb-0 text-muted">We'll refine the designs based on your feedback.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-dark rounded-circle p-2">4</span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Final Approval</h6>
                                    <p class="mb-0 text-muted">You'll review and approve the final design.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-dark rounded-circle p-2">5</span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Delivery</h6>
                                    <p class="mb-0 text-muted">We'll deliver the final files in your preferred format.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6>Have Questions?</h6>
                        <p class="mb-2">Contact us directly:</p>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <p><i class="fas fa-envelope me-2"></i><a href="mailto:sjbps_10@yahoo.com" style="color: black; text-decoration: none;">sjbps_10@yahoo.com</a></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone me-2"></i>
                            <p><i class="fas fa-phone me-2"></i><a href="tel:+63282965896" style="color: black; text-decoration: none;">(+632) 8296-5896</a> | <a href="tel:+639201225764" style="color: black; text-decoration: none;">0920 122 5764</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this script before the closing </body> tag -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handler
        const inquiryForm = document.getElementById('inquiryForm');
        
        if (inquiryForm) {
            inquiryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // In a real implementation, you would send this data to your server
                // This is just a visual confirmation for demonstration
                alert('Thank you for your inquiry! We will contact you within 24-48 hours.');
                inquiryForm.reset();
            });
        }
        
        // Toggle search popup
        const searchToggle = document.getElementById('searchToggle');
        const searchPopup = document.getElementById('searchPopup');
        
        if (searchToggle && searchPopup) {
            searchToggle.addEventListener('click', function() {
                searchPopup.classList.toggle('active');
            });
            
            // Close search popup when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container')) {
                    searchPopup.classList.remove('active');
                }
            });
        }
    });
</script>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>