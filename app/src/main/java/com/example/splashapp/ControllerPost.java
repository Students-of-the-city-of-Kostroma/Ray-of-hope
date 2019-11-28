package com.example.splashapp;

public abstract class ControllerPost {

    public ControllerPost() { }

    public abstract boolean Add(M_Post MPost);

    public abstract boolean Update(M_Post MPost);

    public abstract boolean Delete(M_Post MPost);

    public abstract boolean AddComment(M_Post MPost, M_Comment comment);

    public abstract boolean DeleteComment(M_Post MPost, M_Comment comment);

    public abstract boolean RefreshList(M_Post MPost, M_Comment comment);

}
