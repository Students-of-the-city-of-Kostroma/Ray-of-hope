package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;
import java.util.List;

public abstract class M_Post {
    private String name, description;
    private String id;
    private Date postDate;
    public List<M_Comment> linkComment;

    public M_Post(String id, @NotNull String name, @NotNull String description, @NotNull Date postDate) {
        this.id=id;
        this.name = name;
        this.description = description;
        this.postDate = postDate;
    }

    public String getId() {
        return id;
    }

    public void setId(@NotNull String id) {
        this.id = id;
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

    public boolean CreateComment (String text)
    {
        return false;
    }

    public List<M_Comment> getLinkComment(){return linkComment;}
}
