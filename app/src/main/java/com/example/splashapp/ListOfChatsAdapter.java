package com.example.splashapp;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class ListOfChatsAdapter extends RecyclerView.Adapter<ListOfChatsAdapter.ViewHolder> {


private List<M_Chat> Org;
private List<M_Chat> itemsCopy=new ArrayList<M_Chat>();
private Context context;
private ItemClickListener mClickListener;

public ListOfChatsAdapter(Context context,List<M_Chat> Org)
        {
        this.Org=Org;
        this.context=context;
        itemsCopy.addAll(Org);
        }

@Override
public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
        {
        View v = LayoutInflater.from(parent.getContext())
        .inflate(R.layout.org_in_list,parent,false);
        return  new ViewHolder(v);
        }

@Override
public void onBindViewHolder(ViewHolder  holder, int position) {
        M_Chat or=Org.get(position);
        holder.id=or.getId();
        //holder.name.setText(or.getWithWho());
        holder.name.setText("Какое-то название");
        //holder.about.setText(or.getLastMessage());
        holder.about.setText("тест");
        Picasso.get().load(R.mipmap.about_logo).into(holder.imageView);
        }

@Override
public int getItemCount() {
        return Org.size();
        }


public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
    public String id;
    public TextView about;
    public ImageView imageView;
    public TextView name;



    public ViewHolder (View itemView)
    {
        super(itemView);
        imageView =(ImageView) itemView.findViewById(R.id.imageView12);
        name=(TextView) itemView.findViewById(R.id.textView31);
        about=(TextView) itemView.findViewById(R.id.textView32);

        itemView.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
    }
}

    public M_Chat getOrg(int id) {
        return Org.get(id);
    }

    public void setClickListener(ListOfChatsAdapter.ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

public interface ItemClickListener {
    void onItemClick(View view, int position);
}
}
