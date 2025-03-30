// Calm UI Animations and Interactions

document.addEventListener('DOMContentLoaded', function() {
    // Handle loading skeleton animations
    const skeletonLoaders = document.querySelectorAll('.skeleton-loader');
    skeletonLoaders.forEach(loader => {
        loader.classList.add('shimmer');
    });
    
    // Automatically hide loading skeletons after a delay
    const loadingViews = document.querySelectorAll('#loading-view');
    const contentViews = document.querySelectorAll('#content-view');
    
    if (loadingViews.length > 0 && contentViews.length > 0) {
        setTimeout(() => {
            loadingViews.forEach(view => {
                view.style.display = 'none';
            });
            contentViews.forEach(view => {
                view.style.display = 'block';
            });
        }, 800); // Adjust delay time as needed
    }
    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.card, .bug-card');
    cards.forEach(card => {
        card.classList.add('fade-in');
    });

    // Initialize tooltips
    const tooltips = document.querySelectorAll('.tooltip');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            const tooltipText = this.querySelector('.tooltip-text');
            if (tooltipText) {
                tooltipText.style.visibility = 'visible';
                tooltipText.style.opacity = '1';
            }
        });

        tooltip.addEventListener('mouseleave', function() {
            const tooltipText = this.querySelector('.tooltip-text');
            if (tooltipText) {
                tooltipText.style.visibility = 'hidden';
                tooltipText.style.opacity = '0';
            }
        });
    });

    // View toggle functionality (list/grid view)
    const viewToggleButtons = document.querySelectorAll('.view-toggle .btn');
    const listView = document.getElementById('list-view');
    const gridView = document.getElementById('grid-view');
    
    if (viewToggleButtons.length > 0 && listView && gridView) {
        viewToggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                viewToggleButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show the selected view
                if (this.dataset.view === 'list') {
                    listView.style.display = 'block';
                    gridView.style.display = 'none';
                } else {
                    listView.style.display = 'none';
                    gridView.style.display = 'block';
                }
            });
        });
    }

    // Add subtle hover animation to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Form focus effects
    const formInputs = document.querySelectorAll('.form-control');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Auto-hide notifications after 5 seconds
    const notifications = document.querySelectorAll('.alert');
    notifications.forEach(notification => {
        setTimeout(() => {
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            }
        }, 5000);
    });

    // Add smooth transition when selecting bug priority/status
    const selectInputs = document.querySelectorAll('select.form-control');
    selectInputs.forEach(select => {
        select.addEventListener('change', function() {
            this.classList.add('changed');
            setTimeout(() => {
                this.classList.remove('changed');
            }, 300);
        });
    });
});
