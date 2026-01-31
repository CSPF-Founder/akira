# Docker

Docker configuration for Akira panel images.

> **Note:** These files are excluded from GitHub release archives via `.gitattributes`.

## Quick Start

```bash
docker pull cysecurity/akira:latest
docker run -d -p 8080:80 cysecurity/akira:latest
```

## Building Locally

```bash
docker build --build-arg AKIRA_VERSION=v1.0.0 -t akira:local ./docker/apache
```

## Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `PHP_MEMORY_LIMIT` | `256M` | PHP memory limit |

## Health Checks

The image does not include a built-in health check (following official PHP/WordPress image standards).

To add a health check in docker-compose:

```yaml
services:
  akira:
    image: cysecurity/akira:latest
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost/"]
      interval: 30s
      timeout: 10s
      retries: 3
      start_period: 5s
```

For Kubernetes, use livenessProbe/readinessProbe instead.

## Automated Publishing

Docker images are automatically published to Docker Hub when a version tag is pushed:

- Tags matching `v*` trigger the workflow
- Multi-architecture images (amd64, arm64) are built
- Images are tagged with the version and `latest` (for stable releases)
