let api_key = 'test2'; //change this to test different companies or to test failed authrisation

document.getElementById('search-btn').addEventListener('click', function() {
    //grab values from html form
    const county = document.getElementById('county').value;
    const requiresDbs = document.getElementById('requires_dbs').value;
    const position = document.getElementById('position').value;

    //create query to use in api call
    let query = '?';
    if (county) query += `county=${county}&`;
    if (requiresDbs) query += `requires_dbs=${requiresDbs}&`;
    if (position) query += `position=${position}&`;

    //call the api
    fetch(`/api/applicants${query}`, {
        headers: {
            'Authorisation': api_key
        }
    })
    //handle the response
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                // Unauthorized
                throw new Error('Unauthorized: Invalid API key.');
            }
            throw new Error('Unknown Error');
        }
        return response.json();
    })
    //render results for frontend
    .then(data => {
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = '';
        data.forEach(applicant => {
            const applicantDiv = document.createElement('div');
            applicantDiv.className = 'applicant';
            const downloadLink = document.createElement('a');
            downloadLink.className = 'download-link';
            downloadLink.href = '#';  // Temporary href
            downloadLink.textContent = 'Download CV';
            downloadLink.addEventListener('click', function(event) {
                event.preventDefault();
                downloadCv(applicant.id);
            });
            applicantDiv.innerHTML = `
                <h2>${applicant.name}</h2>
                <p><strong>County:</strong> ${applicant.county}</p>
                <p><strong>Email:</strong> ${applicant.email}</p>
                <p><strong>Phone:</strong> ${applicant.phone}</p>
                <p><strong>Address 1:</strong> ${applicant.address1}</p>
                <p><strong>County:</strong> ${applicant.county}</p>
                <p><strong>Country:</strong> ${applicant.country}</p>
                <p><strong>Postcode:</strong> ${applicant.postcode}</p>
                <p><strong>Requires DBS:</strong> ${applicant.requires_dbs_check ? 'Yes' : 'No'}</p>
                <p><strong>Position Applied For:</strong> ${applicant.applied_for}</p>
            `;
            applicantDiv.appendChild(downloadLink);
            resultsDiv.appendChild(applicantDiv);
            
        });
    })
    //handle failed authorisation and log error along with an alert to the user
    .catch(error => {
        console.error('Error:', error.message);
        alert('Failed to fetch data: ' + error.message);
    });
});

function downloadCv(applicantId) {
    //call download cv api
    fetch(`/api/applicants/download-cv`, {
        headers: {
            'Authorisation': api_key  // Replace with your actual API key
        }
    })
    //handle response
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Unauthorized: Invalid API key.');
            }
            throw new Error('Unkown Error');
        }
        return response.blob();
    })
    //create a blob and temporarily store file available to download
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'cv.rtf';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    //handle failed authorisation and log error along with an alert to the user
    .catch(error => {
        console.error('Error:', error.message);
        alert('Failed to download CV: ' + error.message);
    });
}