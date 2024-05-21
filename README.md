# German Query Vector Embedding using Google BERT as an Azure Function

This Azure Function App is designed to accept an HTTP trigger with a query and use Google's BERT (Bidirectional Encoder Representations from Transformers) model in German to create a vector embedding for the query.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- Python 3.7 or higher
- PyTorch
- Transformers library by Hugging Face
- Azure Functions Core Tools

### Installation

Follow the Azure Functions Python Developer guide to deploy this function locally.

## Local Usage

To use this project, you can run the Azure Function App locally and make a POST request to the function's endpoint with your query as a parameter:

```bash
func start
```

Then, make a POST request:

```bash
curl -X POST http://localhost:7071/api/FunctionName -H "Content-Type: application/json" -d '{"text":"Your query here"}'
```

This will return a vector embedding for your query using the German BERT model.

## Deploying to Azure

Follow the Azure Functions Python developer guide to deploy this function app to Azure.