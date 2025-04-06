<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Metro District Designs Homepage Editor</title>
    <link rel="icon" type="image/png" href="images/logo/threadcraft-logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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

        .nav-icons {
            display: flex;
            align-items: center;
            color: white;
        }

        .nav-icons i {
            cursor: pointer;
            margin-left: 15px;
        }

        /* New Styles for Dark Theme */
        .sidebar {
            background-color: #1E1E1E;
            color: white;
            min-height: calc(100vh - 60px);
            padding-top: 20px;
            width: 250px;
            position: fixed;
            left: 0;
            top: 60px;
        }
        
        .sidebar-link {
            color: #f8f9fa;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #333333;
            border-left: 4px solid #dc3545;
        }
        
        .sidebar-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .breadcrumb-container {
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .card-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-height: 150px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .card-container:hover {
            transform: scale(1.03);
        }
        
        .card-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 22px;
            color: #555;
        }
        
        .metric-card {
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px;
        }
        
        .metric-card.red { background-color: #dc3545; }
        .metric-card.orange { background-color: #fd7e14; }
        .metric-card.green { background-color: #198754; }
        .metric-card.blue { background-color: #0d6efd; }
        .metric-card.navy { background-color: #212529; }
        .metric-card.yellow { background-color: #ffc107; }
        .metric-card.purple { background-color: #6f42c1; }
        .metric-card.teal { background-color: #20c997; }
        .metric-card.gray { background-color: #6c757d; }
        .metric-card.pink { background-color: #d63384; }
        .metric-card.brown { background-color: #8d6e63; }
        
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0 20px;
            color: #333;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
        }
        
        /* Modal customization */
        .modal-header {
            background-color: #1E1E1E;
            color: white;
            border-bottom: 1px solid #333;
        }
        
        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
        
        /* Custom table styling */
        .table thead th {
            background-color: #1E1E1E;
            color: white;
            border-color: #333;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="Homepage.php">
            <img src="/api/placeholder/40/40" id="navLogo" class="rounded-circle me-2">
            Metro District Designs
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-circle"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Container with Sidebar -->
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-auto">
            <div class="sidebar">
                <a href="admin-dashboard.php" class="sidebar-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="admin-products.php" class="sidebar-link">
                    <i class="fas fa-box"></i> Product Stock
                </a>
                <a href="admin-sales.php" class="sidebar-link">
                    <i class="fas fa-chart-line"></i> Sales Record
                </a>
                <a href="admin-accounts.php" class="sidebar-link active">
                    <i class="fas fa-users"></i> Account Manager
                </a>
                <a href="admin-profile.php" class="sidebar-link">
                    <i class="fas fa-user-cog"></i> Profile
                </a>
                <a href="homepage.php" class="sidebar-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="logout.php" class="sidebar-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="col">
            <div class="main-content">
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Homepage Editor</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Title -->
                <div class="page-title">
                    <span>Homepage Editor</span>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#previewModal">
                        <i class="fas fa-eye"></i> Preview Homepage
                    </button>
                </div>
                
                <!-- Main Page Section -->
                <div class="section-title">Main Page</div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Brand Logo</div>
                            <div class="metric-card red" data-bs-toggle="modal" data-bs-target="#editLogoModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Featured Collection</div>
                            <div class="metric-card orange" data-bs-toggle="modal" data-bs-target="#editCarouselModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Best Sellers</div>
                            <div class="metric-card green" data-bs-toggle="modal" data-bs-target="#editBestSellersModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Customer Reviews</div>
                            <div class="metric-card blue" data-bs-toggle="modal" data-bs-target="#editTestimonialsModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shirt Collections Section -->
                <div class="section-title">Shirt Collections</div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Casual Collection</div>
                            <div class="metric-card purple" data-bs-toggle="modal" data-bs-target="#editCasualModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Formal Collection</div>
                            <div class="metric-card teal" data-bs-toggle="modal" data-bs-target="#editFormalModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Graphic Tees</div>
                            <div class="metric-card pink" data-bs-toggle="modal" data-bs-target="#editGraphicModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Store Features Section -->
                <div class="section-title">Store Features</div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Size Guide</div>
                            <div class="metric-card navy" data-bs-toggle="modal" data-bs-target="#editSizeGuideModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Fabric Catalog</div>
                            <div class="metric-card brown" data-bs-toggle="modal" data-bs-target="#editFabricModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card-container">
                            <div class="card-title">Custom Design Form</div>
                            <div class="metric-card yellow" data-bs-toggle="modal" data-bs-target="#editCustomFormModal">
                                <div class="metric-value">Edit</div>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Templates -->
<!-- Logo Modal -->
<div class="modal fade" id="editLogoModal" tabindex="-1" aria-labelledby="editLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLogoModalLabel">Edit Brand Logo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="logoForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <h6>Current Logo:</h6>
                    <div class="text-center mb-3">
                        <img id="currentLogo" src="/api/placeholder/150/150" alt="Current Logo" class="img-fluid rounded-circle">
                    </div>
                    <div class="mb-3">
                        <label for="logoFile" class="form-label">Upload New Logo</label>
                        <input type="file" class="form-control" id="logoFile" name="logoFile" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Testimonials Modal -->
<div class="modal fade" id="editTestimonialsModal" tabindex="-1" aria-labelledby="editTestimonialsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestimonialsModalLabel">Manage Customer Reviews</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="testimonialsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab" aria-controls="current" aria-selected="true">Current Reviews</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false">Add New</button>
                    </li>
                </ul>
                <div class="tab-content p-3" id="testimonialsTabContent">
                    <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
                        <div id="testimonialsList">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add-tab">
                        <form id="addTestimonialForm">
                            <div class="mb-3">
                                <label for="clientName" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="clientName" name="clientName" required>
                            </div>
                            <div class="mb-3">
                                <label for="clientCompany" class="form-label">Purchased Item (Optional)</label>
                                <input type="text" class="form-control" id="clientCompany" name="clientCompany">
                            </div>
                            <div class="mb-3">
                                <label for="testimonialText" class="form-label">Review Content</label>
                                <textarea class="form-control" id="testimonialText" name="testimonialText" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="clientPhoto" class="form-label">Customer Photo (Optional)</label>
                                <input type="file" class="form-control" id="clientPhoto" name="clientPhoto" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating (1-5 stars)</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="">Select rating</option>
                                    <option value="5">5 Stars (Excellent)</option>
                                    <option value="4">4 Stars (Very Good)</option>
                                    <option value="3">3 Stars (Good)</option>
                                    <option value="2">2 Stars (Fair)</option>
                                    <option value="1">1 Star (Poor)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Add Review</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch logo
        fetch("databases/fetch_logo.php")
            .then(response => response.json())
            .then(data => {
                let navLogo = document.getElementById("navLogo");
                if (data.status === "success" && data.image) {
                    navLogo.src = data.image;
                    document.getElementById("currentLogo").src = data.image;
                } else {
                    console.error("Error:", data.message);
                    navLogo.src = "/api/placeholder/40/40";
                }
            })
            .catch(error => console.error("Error fetching logo:", error));
            
        // Load testimonials when the modal opens
        document.getElementById("editTestimonialsModal").addEventListener("show.bs.modal", function() {
            loadTestimonials();
        });
        
        // Handle the form submission for adding new testimonials
        document.getElementById("addTestimonialForm").addEventListener("submit", function(e) {
            e.preventDefault();
            addNewTestimonial();
        });
    });
    
    function loadTestimonials() {
        fetch("databases/fetch_testimonials.php")
            .then(response => response.json())
            .then(data => {
                const testimonialsList = document.getElementById("testimonialsList");
                if (data.status === "success" && data.testimonials.length > 0) {
                    testimonialsList.innerHTML = "";
                    
                    data.testimonials.forEach(testimonial => {
                        const testimonialElement = document.createElement("div");
                        testimonialElement.className = "card mb-3";
                        testimonialElement.innerHTML = `
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="${testimonial.photo || '/api/placeholder/40/40'}" alt="${testimonial.name}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">${testimonial.name}</h6>
                                            <small class="text-muted">${testimonial.company || 'Customer'}</small>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        ${'★'.repeat(testimonial.rating)}${'☆'.repeat(5-testimonial.rating)}
                                    </div>
                                </div>
                                <p class="mb-2">${testimonial.text}</p>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-danger" onclick="deleteTestimonial(${testimonial.id})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        `;
                        testimonialsList.appendChild(testimonialElement);
                    });
                } else {
                    testimonialsList.innerHTML = "<p class='text-center'>No testimonials found. Add your first customer review!</p>";
                }
            })
            .catch(error => {
                console.error("Error loading testimonials:", error);
                document.getElementById("testimonialsList").innerHTML = 
                    "<div class='alert alert-danger'>Error loading testimonials. Please try again later.</div>";
            });
    }
    
    function addNewTestimonial() {
        const formData = new FormData(document.getElementById("addTestimonialForm"));
        
        fetch("databases/add_testimonial.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                // Display success message
                const successAlert = document.createElement("div");
                successAlert.className = "alert alert-success";
                successAlert.textContent = "Testimonial added successfully!";
                document.getElementById("addTestimonialForm").prepend(successAlert);
                
                // Clear the form
                document.getElementById("addTestimonialForm").reset();
                
                // Remove the success message after 3 seconds
                setTimeout(() => {
                    successAlert.remove();
                }, 3000);
                
                // Switch to the Current Reviews tab and reload testimonials
                document.getElementById('current-tab').click();
                loadTestimonials();
            } else {
                // Display error message
                const errorAlert = document.createElement("div");
                errorAlert.className = "alert alert-danger";
                errorAlert.textContent = data.message || "An error occurred while adding the testimonial.";
                document.getElementById("addTestimonialForm").prepend(errorAlert);
                
                // Remove the error message after 3 seconds
                setTimeout(() => {
                    errorAlert.remove();
                }, 3000);
            }
        })
        .catch(error => {
            console.error("Error adding testimonial:", error);
            const errorAlert = document.createElement("div");
            errorAlert.className = "alert alert-danger";
            errorAlert.textContent = "An error occurred while adding the testimonial. Please try again later.";
            document.getElementById("addTestimonialForm").prepend(errorAlert);
        });
    }
    
    function deleteTestimonial(id) {
        if (confirm("Are you sure you want to delete this testimonial? This action cannot be undone.")) {
            fetch("databases/delete_testimonial.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    loadTestimonials();
                } else {
                    alert(data.message || "An error occurred while deleting the testimonial.");
                }
            })
            .catch(error => {
                console.error("Error deleting testimonial:", error);
                alert("An error occurred while deleting the testimonial. Please try again later.");
            });
        }
    }
</script>
</body>
</html>