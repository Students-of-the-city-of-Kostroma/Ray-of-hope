package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;

public abstract class Post extends Identified {
    private String name, description;
    private Date postDate;

    public Post(String id, @NotNull String name, @NotNull String description, @NotNull Date postDate) {
        super(id);
        this.name = name;
        this.description = description;
        this.postDate = postDate;
    }

    public String getName() {
        return name;
    }

    public void setName(@NotNull String name) {
        this.name = name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(@NotNull String description) {
        this.description = description;
    }

    public Date getPostDate() {
        return postDate;
    }

    public void setPostDate(@NotNull Date postDate) {
        this.postDate = postDate;
    }
}
