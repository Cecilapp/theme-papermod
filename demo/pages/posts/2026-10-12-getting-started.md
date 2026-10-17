---
title: Getting started with PaperMod
description: How to install the theme and write your first post.
tags: [cecil, theme]
---
Install the theme with Composer, then enable it in your `config.yml`.

```bash
composer require cecil/theme-papermod
```

```yaml
theme:
  - papermod
```

## Write your first post

Create a Markdown file in `pages/posts/`, prefixed by its date:

```plaintext
pages/posts/2026-10-12-getting-started.md
```

The post is then available at `/posts/2026/10/12-getting-started/`.
