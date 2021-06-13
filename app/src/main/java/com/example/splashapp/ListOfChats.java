package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.SearchView;
import android.widget.TabHost;

import java.util.List;

public class ListOfChats extends AppCompatActivity implements ListOfChatsAdapter.ItemClickListener  {

    public static String testId;
    private M_Organization OrgTest;
    private ListOfChatsAdapter adapter;
    private List<M_Chat> Orgs=C_Chat.ListChat;
    SearchView searchView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.chats_blank);


        /*setTitle("TabHost");

        TabHost tabHost = (TabHost) findViewById(R.id.tabHost);

        tabHost.setup();

        TabHost.TabSpec tabSpec = tabHost.newTabSpec("tag1");

        tabSpec.setContent(R.id.linearLayout);
        tabSpec.setIndicator("Диалоги");
        tabHost.addTab(tabSpec);

        tabHost.setCurrentTab(0);

        RecyclerView recyclerView = findViewById(R.id.frameLayout);
        LinearLayoutManager horizontalLayoutManager
                = new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false);
        recyclerView.setLayoutManager(horizontalLayoutManager);
        adapter = new ListOfChatsAdapter(this, Orgs);
        adapter.setClickListener(this);
        try {        recyclerView.setAdapter(adapter);}
        catch (Exception e) {
            e.printStackTrace();
        }
        searchView=(SearchView) findViewById(R.id.search_view1); */

    }

    @Override
    public void onItemClick(View view, int position) {
        try{
            C_Chat.TestId=Integer.parseInt((adapter.getOrg(position)).getId());
            Intent intent = new Intent(this, ThisChat.class);
            startActivity(intent);
        }catch (Exception e) {
            e.printStackTrace();
        }
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
    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
        startActivity(intent);
        finish();
    }
    public void ToChats(View view)
    {
        Intent intent = new Intent(this, ListOfChats.class);
        startActivity(intent);
        finish();
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
