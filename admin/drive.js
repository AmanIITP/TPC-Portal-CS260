var CLIENT_ID = '677889249776-s5rb475hn9s8naotk21ef6ntmkn7scbd.apps.googleusercontent.com';
var API_KEY = 'AIzaSyDCWM8646LrzTQecQRU7vOrCffD3sRL7Bo';
var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/drive/v3/rest"];
var SCOPES = 'https://www.googleapis.com/auth/drive.readonly';

gapi.load('client', () => {
    // Initialize the Google API client with your API key and the required scopes
    gapi.client.init({
        apiKey: API_KEY,
        discoveryDocs: ['https://www.googleapis.com/discovery/v1/apis/drive/v3/rest'],
        scope: 'https://www.googleapis.com/auth/drive.readonly'
    }).catch((error) => {
        console.error(`Google API initialization error: ${error}`);
    });
});

/**
 * Returns the download URL for a file with the specified name in the specified folder.
 *
 * @param {string} folderId - The ID of the folder to search for the file.
 * @param {string} fileName - The name of the file to download.
 * @returns {Promise<string>} - The download URL for the file.
 */
async function getDownloadUrl(folderId, fileName) {
    try {
        // Get the file ID for the specified file name in the specified folder
        const response = await gapi.client.drive.files.list({
            q: `'${folderId}' in parents and fullText contains '${fileName}' and trashed=false`,
            fields: 'files(id)',
        });

        const files = response.result.files;
        if (!files || files.length === 0) {
            throw new Error(`File '${fileName}' not found in folder.`);
        }

        // Get the download URL for the file using the file ID
        const fileId = files[0].id;
        const file = await gapi.client.drive.files.get({
            fileId: fileId,
            fields: 'webContentLink'
        });
        return file.result.webContentLink;
    } catch (error) {
        console.error(`Error getting download URL for file '${fileName}': ${error}`);
        throw error;
    }
}