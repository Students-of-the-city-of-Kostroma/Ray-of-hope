package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.widget.CompoundButton;
import android.widget.SearchView;
import android.view.View;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.widget.Button;
import android.widget.TabHost;

import com.example.splashapp.Dialogs.SpinnerDialog;

import java.util.ArrayList;
import java.util.List;

public class ListOfOrg extends AppCompatActivity implements ListOfOrgAdapter.ItemClickListener {

    public static String testId;
    private M_Organization OrgTest;
    private ListOfOrgAdapter adapter;
    private ListOfOrgAdapter adapter2;
    private List<M_Organization> Orgs=C_Organization.ListOrganization;//потом перенести в контроллер
    private List<M_Organization> FavOrgs=new ArrayList<M_Organization>();
    SearchView searchView;
    public static String forsCity="", forsAct="";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_of_org);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        Network.numberorglist=0;
        Orgs=new Network().ListOrgs(0, "all");


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();



        setTitle("TabHost");

        TabHost tabHost = (TabHost) findViewById(R.id.tabHost);

        tabHost.setup();

        TabHost.TabSpec tabSpec = tabHost.newTabSpec("tag1");

        tabSpec.setContent(R.id.linearLayout);
        tabSpec.setIndicator("Все");
        tabHost.addTab(tabSpec);

        tabSpec = tabHost.newTabSpec("tag2");
        tabSpec.setContent(R.id.linearLayout2);
        tabSpec.setIndicator("Любимые");
        tabHost.addTab(tabSpec);

        tabHost.setCurrentTab(0);

        RecyclerView recyclerView = findViewById(R.id.frameLayout);
        LinearLayoutManager horizontalLayoutManager
                = new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false);
        recyclerView.setLayoutManager(horizontalLayoutManager);
        recyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                super.onScrolled(recyclerView, dx, dy);
                if (!Network.isload) {
                    List<M_Organization> Orgs1 = new Network().ListOrgs(Network.numberorglist, "all");
                    if (Orgs1 != null) {
                        Orgs.addAll(Orgs1);
                        adapter.notifyDataSetChanged();
                    }
                }
            }
        });
        adapter = new ListOfOrgAdapter(this, Orgs);
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
                adapter.filter(query, forsCity, forsAct);
                return true;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                adapter.filter(newText,forsCity, forsAct);
                return true;
            }
        });} catch (Exception e) {
                e.printStackTrace();
            }
    }

    @Override
    public void onItemClick(View view, int position) {
        try{
            testId=(adapter.getOrg(position)).getId();
            Intent intent = new Intent(this, ViewOrg.class);
            startActivity(intent);
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

    public void ChoiceOrg(View view)
    {
        Intent intent = new Intent(this, ViewOrg.class);
        Button b=(Button)view;
        testId=b.getText().toString();
        int k=testId.lastIndexOf(" ")+1;
        testId=testId.substring(k);
        startActivity(intent);
        finish();
    }

    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
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
    public void ToChats(View view)
    {
        Intent intent = new Intent(this, ListOfChats.class);
        startActivity(intent);
        finish();
    }
    public void OnParamClick (View view)
    {
        SpinnerDialog sDialog = new SpinnerDialog();
        sDialog.show(getFragmentManager(), "SpinnerDialog");
    }
    public  void ToMyProf(View view)
    {
        boolean cit=Choice.citezen;
        if (cit) {
            Intent intent = new Intent(this, CitProf.class);
            startActivity(intent);
        }
        else { Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);}

        finish();
    }

}
