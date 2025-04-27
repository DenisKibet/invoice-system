<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Resources</title>
    <?php include 'css.php' ?>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> -->
    <style>
        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 4rem 0;
            margin-bottom: 3rem;
        }

        .resource-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .resource-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .category-title {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .category-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 2px;
        }

        .resource-link {
            display: inline-flex;
            align-items: center;
            color: #0d6efd;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background-color: rgba(13, 110, 253, 0.1);
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .resource-link:hover {
            background-color: rgba(13, 110, 253, 0.2);
            transform: translateX(5px);
        }

        .search-box {
            max-width: 500px;
            margin: 0 auto;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .resources-row {
            display: flex;
            flex-wrap: wrap;
        }

        .resource-col {
            display: flex;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include 'welcome_topbar.php'?>
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4 fw-bold text-primary">Resources Center</h1>
            <p class="lead mb-4 text-muted">Everything you need to get started and succeed with our Invoice System</p>
            
            <div class="search-box">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-input" placeholder="Search resources...">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Getting Started Section -->
            <div class="col-12 mb-5">
                <h2 class="text-center category-title">Getting Started</h2>
                <div class="row resources-row">
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-rocket resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Quick Start Guide</h5>
                                <p class="card-text text-muted mb-4">Get up and running with our comprehensive quick start guide</p>
                                <a href="#" class="resource-link">
                                    View Guide <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-video resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Video Tutorials</h5>
                                <p class="card-text text-muted mb-4">Watch step-by-step tutorials on key features</p>
                                <a href="#" class="resource-link">
                                    Watch Now <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-book resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Documentation</h5>
                                <p class="card-text text-muted mb-4">Detailed documentation covering all features</p>
                                <a href="#" class="resource-link">
                                    Read Docs <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Resources -->
            <div class="col-12 mb-5">
                <h2 class="text-center category-title">Support Resources</h2>
                <div class="row resources-row">
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-headset resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Help Center</h5>
                                <p class="card-text text-muted mb-4">Browse FAQs and troubleshooting guides</p>
                                <a href="#" class="resource-link">
                                    Get Help <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-comments resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Community Forum</h5>
                                <p class="card-text text-muted mb-4">Connect with other users and share experiences</p>
                                <a href="#" class="resource-link">
                                    Join Discussion <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-ticket-alt resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Support Tickets</h5>
                                <p class="card-text text-muted mb-4">Submit and track your support requests</p>
                                <a href="#" class="resource-link">
                                    Submit Ticket <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Resources -->
            <div class="col-12">
                <h2 class="text-center category-title">Additional Resources</h2>
                <div class="row resources-row">
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-graduation-cap resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Best Practices</h5>
                                <p class="card-text text-muted mb-4">Learn tips and tricks for optimal usage</p>
                                <a href="#" class="resource-link">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-code resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">API Documentation</h5>
                                <p class="card-text text-muted mb-4">Technical documentation for developers</p>
                                <a href="#" class="resource-link">
                                    View API Docs <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 resource-col">
                        <div class="card resource-card shadow-sm p-4">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt resource-icon"></i>
                                <h5 class="card-title fw-bold mb-3">Webinars</h5>
                                <p class="card-text text-muted mb-4">Register for upcoming training sessions</p>
                                <a href="#" class="resource-link">
                                    View Schedule <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'welcome_footer.php'?>

    <?php include 'js.php' ?>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> -->
    <script>
        $(document).ready(function() {
            function equalizeCards() {
                // Reset heights before recalculating
                $('.resource-card').height('auto');
                
                // For each row of resources
                $('.resources-row').each(function() {
                    var tallestCard = 0;
                    
                    // Find the tallest card in this row
                    $(this).find('.resource-card').each(function() {
                        if($(this).height() > tallestCard) {
                            tallestCard = $(this).height();
                        }
                    });
                    
                    // Set all cards in this row to the height of the tallest card
                    $(this).find('.resource-card').height(tallestCard);
                });
            }

            // Run on page load
            equalizeCards();
            
            // Run when window is resized
            $(window).resize(function() {
                equalizeCards();
            });
        // });
        // $(document).ready(function() {
            const $searchInput = $('.search-input');
            const $searchButton = $searchInput.next('button');
            const $resourceCards = $('.resource-card').parent('.resource-col');
            
            // Function to perform the search
            function performSearch() {
                const searchTerm = $searchInput.val().toLowerCase().trim();
                
                if (searchTerm === '') {
                    $resourceCards.show();
                    equalizeCards(); // Re-run the card height equalization
                    return;
                }
                
                $resourceCards.each(function() {
                    const $card = $(this);
                    const title = $card.find('.card-title').text().toLowerCase();
                    const description = $card.find('.card-text').text().toLowerCase();
                    const resourceType = $card.closest('.col-12').find('.category-title').text().toLowerCase();
                    
                    if (title.includes(searchTerm) || 
                        description.includes(searchTerm) || 
                        resourceType.includes(searchTerm)) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                });
                
                // Re-run the card height equalization for visible cards
                equalizeCards();
                
                // Show/hide "no results" message
                updateNoResultsMessage(searchTerm);
            }
            
            // Function to handle no results message
            function updateNoResultsMessage(searchTerm) {
                const $visibleCards = $resourceCards.filter(':visible');
                const $noResults = $('#no-results-message');
                
                if ($visibleCards.length === 0) {
                    if (!$noResults.length) {
                        const message = `
                            <div id="no-results-message" class="col-12 text-center my-5">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No resources found matching "${searchTerm}"
                                </div>
                            </div>`;
                        $resourceCards.first().closest('.row').append(message);
                    }
                } else {
                    $noResults.remove();
                }
            }
            
            // Search on button click
            $searchButton.on('click', performSearch);
            
            // Search on enter key
            $searchInput.on('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
            
            // Live search as user types (with debounce)
            let searchTimeout;
            $searchInput.on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });
            
            // Clear search when user clicks the X in the search input (for webkit browsers)
            $searchInput.on('search', function() {
                if ($(this).val() === '') {
                    performSearch();
                }
            });
        });
    </script>
</body>
</html>