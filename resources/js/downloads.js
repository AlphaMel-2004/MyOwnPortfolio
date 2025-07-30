/**
 * Enhanced Download Functionality
 * Provides better user experience for file downloads
 */
class DownloadManager {
    constructor() {
        this.downloadButtons = document.querySelectorAll('[data-download]');
        this.fileInfoContainer = document.getElementById('file-info-container');
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.checkFileAvailability();
    }
    
    bindEvents() {
        this.downloadButtons.forEach(button => {
            button.addEventListener('click', (e) => this.handleDownload(e));
        });
    }
    
    async handleDownload(e) {
        e.preventDefault();
        
        const button = e.currentTarget;
        const downloadType = button.getAttribute('data-download');
        const downloadUrl = button.getAttribute('href');
        
        if (!downloadUrl) {
            this.showError('Download link not found');
            return;
        }
        
        // Add loading state
        this.setLoadingState(button, true);
        
        try {
            // Check if file is available first
            const fileInfo = await this.getFileInfo();
            const fileData = fileInfo[downloadType];
            
            if (!fileData || !fileData.exists) {
                this.showError(`${downloadType.toUpperCase()} is not available for download`);
                this.setLoadingState(button, false);
                return;
            }
            
            // Proceed with download
            await this.performDownload(downloadUrl, downloadType);
            
        } catch (error) {
            console.error('Download error:', error);
            this.showError('Failed to download file. Please try again.');
        } finally {
            this.setLoadingState(button, false);
        }
    }
    
    async performDownload(url, type) {
        return new Promise((resolve, reject) => {
            const link = document.createElement('a');
            link.href = url;
            link.download = '';
            link.style.display = 'none';
            
            document.body.appendChild(link);
            
            // Add event listeners to track download
            link.addEventListener('click', () => {
                this.trackDownload(type);
            });
            
            link.addEventListener('error', (error) => {
                document.body.removeChild(link);
                reject(error);
            });
            
            // Trigger download
            link.click();
            
            // Clean up
            setTimeout(() => {
                if (document.body.contains(link)) {
                    document.body.removeChild(link);
                }
                resolve();
            }, 1000);
        });
    }
    
    async getFileInfo() {
        try {
            const response = await fetch('/download/info');
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Failed to get file info:', error);
            return {};
        }
    }
    
    async checkFileAvailability() {
        if (!this.fileInfoContainer) return;
        
        try {
            const fileInfo = await this.getFileInfo();
            this.updateFileInfoDisplay(fileInfo);
        } catch (error) {
            console.error('Failed to check file availability:', error);
        }
    }
    
    updateFileInfoDisplay(fileInfo) {
        if (!this.fileInfoContainer) return;
        
        let html = '<div class="file-info">';
        html += '<h6 class="mb-2">File Availability</h6>';
        
        Object.entries(fileInfo).forEach(([type, info]) => {
            const statusClass = info.exists ? 'available' : 'unavailable';
            const statusText = info.exists ? 'Available' : 'Not Available';
            
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-capitalize">${type}:</span>
                    <span class="file-status ${statusClass}">${statusText}</span>
                </div>
            `;
            
            if (info.exists && info.size) {
                html += `
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">Size:</small>
                        <small class="text-muted">${info.size}</small>
                    </div>
                `;
            }
        });
        
        html += '</div>';
        this.fileInfoContainer.innerHTML = html;
    }
    
    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.classList.add('loading');
            button.disabled = true;
        } else {
            button.classList.remove('loading');
            button.disabled = false;
        }
    }
    
    trackDownload(type) {
        // Track download analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'download', {
                'event_category': 'file_download',
                'event_label': type,
                'value': 1
            });
        }
        
        // Log to console for debugging
        console.log(`Download started: ${type}`);
    }
    
    showError(message) {
        // Create error notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <strong>Download Error:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 5000);
    }
    
    showSuccess(message) {
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <strong>Success:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 3000);
    }
}

// Initialize download manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        new DownloadManager();
    } catch (error) {
        console.error('Failed to initialize download manager:', error);
    }
}); 