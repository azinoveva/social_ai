# Social AI

## Introduction

This Laravel app implements two search functionalities: keyword search and semantic search. Both searches are almost identical in functionality.

## Semantic Search

The semantic search functionality is handled by Azure AI search. To use this feature, you will need a running instance of Azure AI search and configure the necessary variables in the `.env` file. Please refer to the documentation for more information on setting up and connecting to Azure AI search.
The vectorizations for semantic search are handled by the Azure Function App in the `bertvectorizer` branch. This branch deploys to Azure Web App.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/azinoveva/social_ai.git
    ```

2. Switch to `azure` branch:

    ```bash
    git fetch 
    git checkout -b azure_local
    git pull origin azure
    ```

3. Install the dependencies:

    ```bash
    composer install
    ```

4. Configure the environment variables:

    - Rename the `.env.example` file to `.env`.
    - Update the necessary variables in the `.env` file.

5. Generate the app key and run the migrations:

    ```bash
    php artisan key:generate
    php artisan migrate
    ```

6. (*Optional*) The app is supplied with an SQLite database: `database/database.sqlite`. If you want to use your own database, you can migrate to a different database by running the following command:

    ```bash
    php artisan migrate
    ```

7. Start the development server:

    ```bash
    php artisan serve
    ```

## Usage

- To perform a keyword search, navigate to the **Keyword Search** page in the navigation and enter your keywords in the search box.
- To perform a semantic search, navigate to the **Semantic Search** page and enter your query in the search box. You will need an instance of `bertvectorizer` function running locally. Please refer to corresponding branch for more.
