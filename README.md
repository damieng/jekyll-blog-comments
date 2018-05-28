# Jekyll Blog Comments

Jekyll is a great tool for creating a statically generated blog but out of the box it doesn't have any support for comments.

This repo provides some tools to address that.  Specifically;

## Includes/templates

The [jekyll/_includes](/jekyll/_includes) folder contains three files that you can include from your Jekyll site to render comments, they are;

- [comment.html](/jekyll/_includes/comment.html) - Renders a single comment
- [comment-new.html](/jekyll/_includes/comment-new.html) - Show a 'leave a comment' form 
- [comments.html](/jekyll/_includes/comments.html) - Loops through comment.html for a post and follows it up with comment-new.html

Copy these to your `_includes` folder then include them from your blog post layout, e.g. my `_layouts/post.html` file looks like this;

```yml
---
layout: default
---
<div class="post {{ page.class }}">
  {% include item.html %}
  {{ page.content }}
  {% include comments.html %}
</div>
```

### Configuring Jekyll for the templates

Finally you will need to add this end of your `_config.yml` so sorting and posting work:

```yml
emptyArray: []

comments:
  receiver: https://{{your-receiver-site}}/api/PostComment}}

```

### Optional post-author highlighting

You need to make sure you have an author block for each post author so it can match when an author responds to his own post with additional styling;

```yml
authors:
  damieng:
    name: Damien Guard
    email: damieng@gmail.com
    url: https://damieng.com
```

If you do not have an author set on each post/page you can define a default one like this;

```yml
defaults:
  -
    scope:
      path: ''
      type: pages
    values:
      layout: page
      author: damieng
  -
    scope:
      path: '_posts'
      type: posts
    values:
      layout: post
      author: damieng
```

## Exporters

### WordPress

- Upload [this file](/exporters/wordpress/export-blog-comments.php) to your site
- Access export-blog-comments.php call from your browser and wait for it to complete
- Download the `/comments/` folder over SSH and then *remove it* and the export-blog-comments.php from your server
- Copy the `/commments/` folder into your Jekyll `_data/` folder

## Receivers

In order to process a new comment do you need a little bit of code running somewhere in the cloud to capture the form post, validate the parameters and write it to your repository.  Here's what we have so far:

* [Azure + GitHub ](https://github.com/damieng/jekyll-blog-comments-azure) creates pull requests against your blog's GitHub repository with the new comment

## Implementation notes

### Data format

The comments are stored in your Jekyll site in individual yml files with the format `_data/comments/{blog-post-slug}/{comment-id}.yml`

The `blog-post-slug` must match the Jekyll slug for the post it relates to while the `comment-id` can be anything unique.

Each file should look something like this file, `_data/comments/wordpress-exporting/12345.yml`

```yml
id: 12345
name: Damien Guard
email: damieng@gmail.com
gravatar: dc72963e7279d34c85ed4c0b731ce5a9
url: https://damieng.com
date: 2007-12-18 18:51:55
message: "This is a great solution for 'dynamic' comments on a static blog!"
```
