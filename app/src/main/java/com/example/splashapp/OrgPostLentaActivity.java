package com.example.splashapp;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import java.util.List;

public class OrgPostLentaActivity extends AppCompatActivity implements LentaAdapter.ItemClickListener {

    String psId;
    private LentaAdapter adapter;
    private List<M_Post> ListPost=C_Organization.current.posts;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_org_post_lenta);

        if (ListPost.size()==0)
        {
            findViewById(R.id.nopost).setVisibility(View.VISIBLE);
        }
        else {
            findViewById(R.id.nopost).setVisibility(View.GONE);
            RecyclerView recyclerView = findViewById(R.id.frameLayout);
            LinearLayoutManager horizontalLayoutManager
                    = new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false);
            recyclerView.setLayoutManager(horizontalLayoutManager);
            adapter = new LentaAdapter(this, ListPost);
            adapter.setClickListener(this);
            try {
                recyclerView.setAdapter(adapter);
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    public void onItemClick(View view, int position) {
        /*try{
            psId=(adapter.getOrg(position)).getId();
            Intent intent = new Intent(this, ViewOrg.class);
            startActivity(intent);
            finish();
        }catch (Exception e) {
            e.printStackTrace();
        } */
    }

    @Override
    public void onBackPressed() {
        if (!C_Organization.MyOrg.getId().equals(C_Organization.current.getId()))
        {Cancel(ViewOrg.class);}
        else  {Cancel(MyOrgProf.class);}
    }

    public void Cancel(Class<?> t)
    {
                Intent intent = new Intent(this, t);
                startActivity(intent);
                finish();
    }

    public  void ToMyProf(View view)
    {
        Cancel(MyOrgProf.class);
    }
    public  void openMenu(View view)
    {
        Cancel( MenuView.class);
    }


    public  void ToListOfOrg(View view)
    {
        Cancel(ListOfOrg.class);
    }
    public void ToLenta(View view)
    {
        Cancel(LentaActivity.class);
    }
    public void ToChats(View view)
    {
        Cancel(ListOfChats.class);
    }
}