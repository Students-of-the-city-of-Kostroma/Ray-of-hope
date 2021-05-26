package com.example.splashapp;

import android.content.Intent;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.Button;
import android.widget.SearchView;
import android.widget.TabHost;

import com.example.splashapp.Dialogs.SpinnerDialog;

import java.util.List;

public class LentaActivity extends AppCompatActivity implements LentaAdapter.ItemClickListener {

    String psId;
    private LentaAdapter adapter;
    private List<M_Activism> ListPost=C_Activitisms.ListActivism;//потом перенести в контроллер
    SearchView searchView;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lenta);
        Network.numberpost=0;
        ListPost=new Network().ListPosts(0, C_Citizen.Iam.getId());
        setTitle("TabHost");

        TabHost tabHost = (TabHost) findViewById(R.id.tabHost);

        tabHost.setup();

        TabHost.TabSpec tabSpec = tabHost.newTabSpec("tag1");

        tabSpec.setContent(R.id.linearLayout);
        tabSpec.setIndicator("Последние записи");
        tabHost.addTab(tabSpec);


        tabHost.setCurrentTab(0);

        RecyclerView recyclerView = findViewById(R.id.frameLayout);
        LinearLayoutManager horizontalLayoutManager
                = new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false);
        recyclerView.setLayoutManager(horizontalLayoutManager);
        recyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                super.onScrolled(recyclerView, dx, dy);
                if (!Network.isload) {
                    List<M_Activism> Posts1 = new Network().ListPosts(Network.numberpost,C_Citizen.Iam.getId());
                    if (Posts1 != null) {
                        ListPost.addAll(Posts1);
                        adapter.notifyDataSetChanged();
                    }
                }
            }
        });
        adapter = new LentaAdapter(this, ListPost);
        adapter.setClickListener(this);
        try {        recyclerView.setAdapter(adapter);}
        catch (Exception e) {
            e.printStackTrace();
        }
        searchView=(SearchView) findViewById(R.id.search_view1);
        try {
            searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
                @Override
                public boolean onQueryTextSubmit(String query) {
                    adapter.filter(query);
                    return true;
                }

                @Override
                public boolean onQueryTextChange(String newText) {
                    adapter.filter(newText);
                    return true;
                }
            });} catch (Exception e) {
            e.printStackTrace();
        }
    }



    @Override
    public void onItemClick(View view, int position) {
        try{
            psId=(adapter.getOrg(position)).getId();
            Intent intent = new Intent(this, ViewOrg.class);
            startActivity(intent);
            finish();
        }catch (Exception e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    public void ChoicePost(View view)
    {
        Intent intent = new Intent(this, ViewOrg.class);
        Button b=(Button)view;
        psId=b.getText().toString();
        int k=psId.lastIndexOf(" ")+1;
        psId=psId.substring(k);
        startActivity(intent);
        finish();
    }
    public  void openMenu(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }

    public  void ToListOfOrg(View view)
    {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }

    public void OnParamClick (View view)
    {
        SpinnerDialog sDialog = new SpinnerDialog();
        sDialog.show(getFragmentManager(), "SpinnerDialog");
    }
}
