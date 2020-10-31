package com.example.splashapp;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.ImageView;
import android.widget.SearchView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.Date;
import java.util.List;

public class ThisChat extends AppCompatActivity {

    String psId;
    private ChatAdapter adapter;
    private List<M_Message> ListPost=C_Chat.ListChat.get(C_Chat.TestId).ListMessage;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_this_chat);


        RecyclerView recyclerView = findViewById(R.id.recyclerView);
        LinearLayoutManager horizontalLayoutManager
                = new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false);
        horizontalLayoutManager.setStackFromEnd(true);
        recyclerView.setLayoutManager(horizontalLayoutManager);
        adapter = new ChatAdapter(this, ListPost);
        try {        recyclerView.setAdapter(adapter);}
        catch (Exception e) {
            e.printStackTrace();
        }
        ImageView imageView = (ImageView) findViewById(R.id.imageView12);
        Picasso.get().load(R.mipmap.about_logo).into(imageView);
        TextView textview= (TextView) findViewById(R.id.textView33);
        textview.setText("Какое-то название");

    }

    public void Back(View view)
    {
        finish();
    }
    public void Send(View view)
    {
        TextView textview= (TextView) findViewById(R.id.mestxt);
        String s=textview.getText().toString();
        Date d=new Date();
        C_Chat.ListChat.get(C_Chat.TestId).CreateMessage(s,true);
        adapter.notifyDataSetChanged();
    }

}
