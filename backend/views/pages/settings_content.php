<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Settings Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="saveSettingsBtn">
        <i class="fas fa-save fa-sm text-white-50"></i> Save Settings
    </button>
</div>

<!-- Settings Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Website Settings</h6>
    </div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label for="siteName">Site Name</label>
                <input type="text" class="form-control" id="siteName" placeholder="Enter site name" value="SyntaxTrust">
            </div>
            <div class="form-group">
                <label for="siteDescription">Site Description</label>
                <textarea class="form-control" id="siteDescription" rows="3" placeholder="Enter site description">Leading IT solutions provider specializing in web development, mobile apps, and digital marketing services.</textarea>
            </div>
            <div class="form-group">
                <label for="siteKeywords">Keywords (JSON array)</label>
                <textarea class="form-control" id="siteKeywords" rows="2" placeholder='["IT solutions", "web development", "mobile apps", "digital marketing"]'>["IT solutions", "web development", "mobile apps", "digital marketing"]</textarea>
            </div>
            <div class="form-group">
                <label for="contactEmail">Contact Email</label>
                <input type="email" class="form-control" id="contactEmail" placeholder="Enter contact email" value="info@syntaxtrust.com">
            </div>
            <div class="form-group">
                <label for="contactPhone">Contact Phone</label>
                <input type="text" class="form-control" id="contactPhone" placeholder="Enter contact phone" value="+62 21 1234 5678">
            </div>
            <div class="form-group">
                <label for="contactAddress">Contact Address</label>
                <textarea class="form-control" id="contactAddress" rows="2" placeholder="Enter contact address">Jl. Teknologi No. 123, Jakarta 12345, Indonesia</textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="socialFacebook">Facebook URL</label>
                    <input type="url" class="form-control" id="socialFacebook" placeholder="Enter Facebook URL" value="https://facebook.com/syntaxtrust">
                </div>
                <div class="form-group col-md-6">
                    <label for="socialTwitter">Twitter URL</label>
                    <input type="url" class="form-control" id="socialTwitter" placeholder="Enter Twitter URL" value="https://twitter.com/syntaxtrust">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="socialInstagram">Instagram URL</label>
                    <input type="url" class="form-control" id="socialInstagram" placeholder="Enter Instagram URL" value="https://instagram.com/syntaxtrust">
                </div>
                <div class="form-group col-md-6">
                    <label for="socialLinkedIn">LinkedIn URL</label>
                    <input type="url" class="form-control" id="socialLinkedIn" placeholder="Enter LinkedIn URL" value="https://linkedin.com/company/syntaxtrust">
                </div>
            </div>
        </form>
    </div>
</div>
