package com.example.splashapp;

public abstract class ControllerPost {

    public ControllerPost() { }

    public abstract M_Post Add(M_Post MPost);

    public abstract M_Post Update(M_Post MPost);

    public abstract M_Post Delete(M_Post MPost);

    public abstract M_Post AddComment(M_Post MPost, M_Comment comment);

    public abstract M_Post DeleteComment(M_Post MPost, M_Comment comment);

    public abstract M_Post RefreshList(M_Post MPost, M_Comment comment);

}
