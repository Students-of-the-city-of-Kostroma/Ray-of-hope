package com.example.splashapp;

public class PostsRequest {
    private int startId, count;

    public PostsRequest(int startId, int count) {
        this.startId = startId;
        this.count = count;
    }

    public int getCount() {
        return count;
    }

    public void setCount(int count) {
        this.count = count;
    }

    public int getStartId() {
        return startId;
    }

    public void setStartId(int startId) {
        this.startId = startId;
    }
}
