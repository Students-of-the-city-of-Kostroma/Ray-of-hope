package com.example.splashapp;

import android.annotation.TargetApi;
import android.os.Build;

import java.util.LinkedList;
import java.util.concurrent.TimeUnit;



public class C_Needs extends ControllerPost{
    private LinkedList<M_Need> ListNeeds;
    public C_Needs() { }

    @TargetApi(Build.VERSION_CODES.CUPCAKE)
    @Override
    public boolean Add(M_Post post) {
        try {
            M_Need _post = (M_Need)post;
            for (M_Need element : ListNeeds) {
                if (element.getId().equals(_post.getId())) {
                    return false;
                }

            }
            CallDB_VerifyObject flow;
            flow  = new CallDB_VerifyObject();
            String[] data  = {"M_Need", _post.getId(), _post.getName(), _post.getDescription(), _post.getPostDate().toString(),
                    _post.getWhatNeed(), Integer.toString(_post.getPercent())};
            flow.execute(data);
            String Ret = "";
            try {
                Ret = flow.get(5, TimeUnit.SECONDS);
            } catch (Exception e) { System.out.println(e.getMessage()); }
            ListNeeds.add(_post);
        }
        catch (Exception e) { System.out.println(e.getMessage()); }
        return true;
    }


    @TargetApi(Build.VERSION_CODES.CUPCAKE)
    @Override
    public boolean Update(M_Post post) {
        M_Need _post = (M_Need)post;
        for (M_Need element : ListNeeds) {
            if (element.getId().equals(_post.getId())) {
                CallDB_VerifyObject flow = new CallDB_VerifyObject();
                String[] data  = {"M_Need", _post.getId(), _post.getName(), _post.getDescription(), _post.getPostDate().toString(),
                        _post.getWhatNeed(), Integer.toString(_post.getPercent())};
                flow.execute(data);
                String Ret = "";
                try {
                    Ret = flow.get(5, TimeUnit.SECONDS);
                } catch (Exception e) { System.out.println(e.getMessage()); }
            }
            return true;
        }
        return false;
    }

    @Override
    public boolean Delete(M_Post post) {
        M_Need _post = (M_Need)post;
        boolean flag = false;
        for (M_Need element : ListNeeds) {
            if (element.getId().equals(_post.getId())) {
                ListNeeds.remove(element);
                flag = true;
                break;
            }
        }
        return flag;
    }

    @Override
    public  boolean AddComment(M_Post Needs, M_Comment comment) { return true; }

    @Override
    public  boolean DeleteComment(M_Post Needs, M_Comment comment) { return true; }

    @Override
    public  boolean RefreshList(M_Post Needs, M_Comment comment){ return true; }
}

