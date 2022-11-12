
const API_URL = `http://127.0.0.1:8000/api`;

const getAuthors = async () => {
    const response = await fetch(`${API_URL}/authors`, {
        headers: { Accept: 'application/json' },
    });

    if (response.ok) {
        const json = await response.json();

        if (json) {
            let authorBody = '';
            const tbodyAuthor = document.getElementById('author-body');

            for (const author of json.data) {
                authorBody += `
                <tr>
                    <td>${author.name}</td>
                    <td>${author.first_surname}</td>
                    <td>${author.second_surname}</td>
                </tr>
                `;
            }

            tbodyAuthor.innerHTML = authorBody;
        }
    }
}

const getBooks = () => {
    fetch(`${API_URL}/books`)
        .then(response => response.json())
        .then(data => {
            let bookBody = '';
            const tbodyBook = document.getElementById('book-body');

            for (const book of data.data) {
                bookBody += `
                <tr>
                    <td>${book.isbn}</td>
                    <td>${book.title}</td>
                    <td>${book.description}</td>
                    <td>${book.published_date}</td>
                </tr>
                `;
            }

            tbodyBook.innerHTML = bookBody;
        });
}

getAuthors();
getBooks();
